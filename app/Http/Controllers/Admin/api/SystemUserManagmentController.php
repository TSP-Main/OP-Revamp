<?php

namespace App\Http\Controllers\Admin\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\otpVerifcation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class SystemUserManagmentController extends Controller
{
    protected $userStatus;
    protected $status;
    protected $temp_status;


    public function __construct()
    {
        $this->userStatus = config('constants.USER_STATUS');
        $this->status = config('constants.QUOTE_STATUS');
        $this->temp_status = config('constants.TEMP_STATUS');
    }

    public function index()
    {
    }

    public function user_login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        try {

            $credentials = $request->only('email', 'password');
            $user = User::where('email', $credentials['email'])->first();

            if ($user) {

                if (in_array($user->status, auth_users())) {

                    if (isset($user->role) && $user->role == user_roles('3')) {

                        $admin = User::where(['role' => user_roles('2'), 'id' => $user->admin_id])->first();
                        if ($admin) {
                            if (!in_array($admin->status, auth_users())) {
                                return response()->json(['status' => 'Deactive', 'message' => 'You are Unauthorized to Login, Contact to the admin']);
                            }
                        } else {
                            return response()->json(['status' => 'Deactive', 'message' => 'You are not assigned  to any admin']);
                        }
                    }

                    if (Auth::attempt($credentials)) {

                        $token = $user->createToken('MyApp')->plainTextToken;
                        session(['user_details' => $user]);
                        return response()->json(['status' => 'success', 'message' => 'User successfully logged in', 'token' => $token]);
                    } else {
                        return response()->json(['status' => 'invalid', 'message' => 'Invalid Credentails or Contact to Admin']);
                    }
                } else if ($user->status == 4) {
                    return response()->json(['status' => 'Unverfied', 'message' => 'User is unverified, Please Check Your Email']);
                } else {
                    return response()->json(['status' => 'Deactive', 'message' => 'You are Unauthorized to Login']);
                }
            } else {

                return response()->json(['status' => 'invalid', 'message' => 'User does not exist'], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error retrieving users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function user_store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'user_pic' => 'image|max:1024',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($request->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        try {
            $user = ($request->id) ? User::find($request->id) : new User();

            $isExistingUser = $user->exists;

            $user->name               = $request->name;
            $user->email              = $request->email;
            $user->phone              = $request->phone;
            $user->address            = $request->address;
            $user->role               = $request->role;
            $user->country            = $request->country;
            $user->zip_code           = $request->zip_code;
            $user->city               = $request->city;
            $user->state              = $request->state;
            $user->password           = Hash::make($request->password);
            $user->created_by         = Auth::id();


            $oldUserPicPath = $user->user_pic;

            if ($request->hasFile('user_pic')) {
                if ($request->id && $oldUserPicPath) {
                    Storage::disk('public')->delete($oldUserPicPath);
                }

                $userPic = $request->file('user_pic');
                $userPicPath = $userPic->store('user_pics', 'public');
                $user->user_pic = $userPicPath;
            }
            $save = $user->save();

            $message = $isExistingUser ? 'User updated successfully' : 'User added successfully';
            return response()->json(['status' => 'success', 'message' => $message, 'data' => $save]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error storing user', 'error' => $e->getMessage()], 500);
        }
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'com_pic' => 'image',
            'user_pic' => 'image',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($request->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        try {
            $user = ($request->id) ? User::find($request->id) : new User();

            $isExistingUser = $user->exists;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->com_name = $request->com_name;
            $user->address = $request->address;
            $user->role = 'Client';

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }


            $oldComPicPath = $user->com_pic;
            $oldUserPicPath = $user->user_pic;

            if ($request->hasFile('com_pic')) {
                if ($request->id && $oldComPicPath) {
                    Storage::disk('public')->delete($oldComPicPath);
                }

                $comPic = $request->file('com_pic');
                $comPicPath = $comPic->store('com_pics', 'public');
                $user->com_pic = $comPicPath;
            }

            if ($request->hasFile('user_pic')) {
                if ($request->id && $oldUserPicPath) {
                    Storage::disk('public')->delete($oldUserPicPath);
                }

                $userPic = $request->file('user_pic');
                $userPicPath = $userPic->store('user_pics', 'public');
                $user->user_pic = $userPicPath;
            }

            $save = $user->save();

            $message = $isExistingUser ? 'User updated successfully' : 'User Register successfully';
            return response()->json(['status' => 'success', 'message' => $message, 'data' => $save]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error storing user', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteUsers(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        try {

            $user = ($request->id) ? User::find($request->id) : '';
            $isExistingUser = $user->exists;

            if ($isExistingUser) {

                $status = $this->userStatus;
                $message  = 'Some thing went wrong';
                $deleted_role = NULL;

                if ($user->role == user_roles(1)) {
                    $user->status = $status['Deleted'];
                    $user->updated_by = $request->deleted_by;
                    $save = $user->save();
                    $message = $save ? 'Super Admin Deleted successfully' : 'Super Admin can not deleted';
                    if ($save) {
                        $deleted_role = 1;
                        if ($request->deleted_by == $user->id) {
                            session()->flush();
                            return response()->json(['status' => 'success', 'message' => 'Your Account has been deleted!', 'role' => $deleted_role, 'logout' => 'yes']);
                        }
                    }
                } else if ($user->role == user_roles(2)) {
                    $user->status = $status['Deleted'];
                    $user->updated_by = $request->deleted_by;
                    $save = $user->save();
                    $message = $save ? 'Admin Deleted successfully' : 'Admin can not deleted';

                    if ($request->delete_all_user) {
                        User::where(['role' => user_roles('3'), 'admin_id' => $request->id])->update(['status' => $status['Deleted'], 'updated_by' => $request->deleted_by]);
                        $message .= "\nAll Users deleted successfully";
                    }

                    if ($save) {
                        $deleted_role = 2;
                        if ($request->deleted_by == $user->id) {
                            session()->flush();
                            return response()->json(['status' => 'success', 'message' => 'Your Account has been deleted!', 'role' => $deleted_role, 'logout' => 'yes']);
                        }
                    }
                } else if ($user->role == user_roles(3)) {
                    $user->status = $status['Deleted'];
                    $user->updated_by = $request->deleted_by;
                    $save = $user->save();
                    $message = $save ? 'User Deleted successfully' : 'User can not deleted';

                    if ($save) {
                        $deleted_role = 3;
                        if ($request->deleted_by == $user->id) {
                            session()->flush();
                            return response()->json(['status' => 'success', 'message' => 'Your Account has been deleted!', 'role' => 'driver', 'role' => $deleted_role, 'logout' => 'yes']);
                        }
                    }
                }
            }


            return response()->json(['status' => 'success', 'message' => $message, 'role' => $deleted_role, 'data' => $save]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'warning', 'message' => 'Error storing user', 'error' => $e->getMessage()], 500);
        }
    }
}
