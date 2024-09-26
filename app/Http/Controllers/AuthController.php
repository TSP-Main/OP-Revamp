<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\PasswordChangeRequest;
use App\Http\Requests\Auth\ProfileRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\OtpVerifiedRequest;
use App\Mail\OTPMail;
use App\Models\Category;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    private $menu_categories;
    protected $status;
    protected $ENV;
    public function __construct()
    {
        $this->user = auth()->user();
        $this->status = config('constants.USER_STATUS');

        $this->menu_categories = Category::where('status', 'Active')
            ->with([
                'subcategory' => function ($query) {
                    $query->where('status', 'Active')
                        ->with([
                            'childCategories' => function ($query) {
                                $query->where('status', 'Active');
                            }
                        ]);
                }
            ])
            ->where('publish', 'Publish')
            ->latest('id')
            ->get()
            ->toArray();

        view()->share('menu_categories', $this->menu_categories);
    }

    public function registerUser(RegisterUserRequest $request)
    {
        if (!auth()->check()) {
            try {
                DB::beginTransaction();

                // Convert DOB to YYYY-MM-DD format
                $dob = "{$request->year}-{$request->month}-{$request->day}";

                // Handle document upload, if provided
                $docPath = $request->file('id_document')
                    ? $request->file('id_document')->storeAs(
                        'user_docs',
                        uniqid() . time() . '_' . $request->file('id_document')->getClientOriginalName(),
                        'public'
                    )
                    : null;

                // Create or update the user
                $user = User::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'name' => ucwords($request->name),
                        'email' => $request->email,
                        'id_document' => $docPath,
                        'zip_code' => $request->zip_code,
                        'password' => Hash::make($request->password),
                        'status' => $this->status['Active'] ?? '',
                        'is_active' => $this->status ?? '',
                        'created_by' => Auth::id() ?? 1,
                    ]
                );

                // Assign role using Spatie, if provided
                if ($request->has('role')) {
                    $user->assignRole($request->role);
                } else {
                    $user->assignRole('user');
                }

                // Create or update the user profile
                UserProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'speciality' => $request->speciality,
                        'phone' => $request->phone,
                        'gender' => $request->gender,
                        'date_of_birth' => $dob,
                        'image' => $request->image,
                        'short_bio' => $request->short_bio,
                    ]
                );

                // Create or update the user address
                UserAddress::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'address' => $request->address,
                        'apartment' => $request->apartment,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                    ]
                );

                // Log in the user if authentication is successful
                if (Auth::attempt($request->only('email', 'password'))) {
                    $token = auth()->user()->createToken('MyApp')->plainTextToken;

                    DB::commit();

                    // Handle redirection
                    $intendedUrl = session('intended_url');
                    session()->forget('intended_url');
                    return redirect($intendedUrl ? route('web.consultationForm') : '/dashboard');
                } else {
                    // Rollback if login fails
                    DB::rollBack();
                    return redirect()->back()->withErrors('Login failed after registration.');
                }

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withErrors('Registration failed, please try again.');
            }
        } else {
            return redirect()->back();
        }
    }
    public function registration_form(Request $request)
    {
        $data['user'] = auth()->user() ?? [];
        if (auth()->user()) {
            return redirect('/admin');
        } else {
            return view('web.pages.registration_form', $data);
        }
    }

    public function loginForm()
    {
        return view('web.pages.login');
    }

    public function login(LoginUserRequest $request)
    {
        // Check if user is already authenticated
        if (auth()->check()) {
            return $this->redirectBasedOnRole(auth()->user());
        }

        $authenticatedUser = auth()->user();
        if (!$authenticatedUser) {
            if ($credentials = $request->only('email', 'password')) {

                // Find the user by email
                $user = User::where('email', $credentials['email'])->first();
                if (!$user) {
                    return redirect()->back()->with([
                        'status' => 'noexistence',
                        'message' => 'User does not exist',
                        'email' => $credentials['email']
                    ], 401);
                }
                // Verify the password using Hash::check
                if (!Hash::check($credentials['password'], $user->password)) {
                    return redirect()->back()->with([
                        'status' => 'invalid',
                        'message' => 'Invalid password',
                        'email' => $credentials['email']
                    ])->withInput();
                }

                // Check if the user is authorized to log in (check user status)
                if (!in_array($user->status, auth_users())) {
                    $statusMessages = [
                        4 => 'User is unverified, please check your email',
                        'default' => 'You are unauthorized to log in',
                    ];
                    $message = $statusMessages[$user->status] ?? $statusMessages['default'];

                    return redirect()->back()->with([
                        'status' => 'Deactive',
                        'message' => $message,
                        'email' => $credentials['email']
                    ]);
                }

                // Attempt to log the user in
                if (Auth::attempt($credentials)) {
                    // Create a token for the user
                    $token = $user->createToken('MyApp')->plainTextToken;

                    // Redirect based on role
                    return $this->redirectBasedOnRole($user);
                } else {
                    return redirect()->back()->with([
                        'status' => 'invalid',
                        'message' => 'Invalid credentials',
                        'email' => $credentials['email']
                    ]);
                }
            }

        } else {
            return view('web.pages.login');
        }
    }

    protected function redirectBasedOnRole($user)
    {
        // Redirect users based on their role using Spatie
        if ($user->hasRole('super_admin')) {
            return redirect('/dashboard');
        }

        if ($user->hasRole('dispensary')) {
            return redirect('/dashboard');
        }

        if ($user->hasRole('doctor')) {
            return redirect('/dashboard');
        }

        if ($user->hasRole('user')) {
            $intendedUrl = session('intended_url');
            session()->forget('intended_url');
            return $intendedUrl ? redirect()->route('web.consultationForm') : redirect('/dashboard');
        }

        return redirect('/');
    }

    public function logout()
    {
        $user = auth()->user();
        // Flush the session and log out the user
        session()->flush();
        Auth::logout();

        // Role-based redirection using Spatie roles
        if ($user && $user->hasRole('super_admin')) {
            return redirect('/login');
        }
        if ($user && $user->hasRole('dispensary')) {
            return redirect('/login');
        }
        if ($user && $user->hasRole('doctor')) {
            return redirect('/login');
        }
        // Default role or if no role, redirect to homepage
        return redirect('/');
    }

    public function forgot_password()
    {
        $user = auth()->user();
        if (!$user) {
            return view('web.pages.forgot_password');
        } else {
            return redirect()->back();
        }
    }

    public function change_password()
    {
        $user = auth()->user();
        if (!$user) {
            return view('web.pages.change_password');
        } else {
            return redirect()->back();
        }
    }

    public function send_otp(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $otp = mt_rand(100000, 999999);
                $user->otp = $otp;
                $user->save();
                Mail::to($request->email)->send(new OTPMail($otp));
                return redirect()->route('changePassword')->with(['status' => 'success', 'message' => "Please check you'r mail for OTP", 'email' => $request->email]);
            } else {
                return redirect()->back()->withInput()->withErrors(['email' => 'The provided email is incorrect.']);
            }
        } else {
            return redirect()->back();
        }
    }

public function verify_otp(OtpVerifiedRequest $request)
{
    $user = auth()->user();
    if (!$user) {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->otp == trim($request->otp)) {
                $user->password = Hash::make($request->password);
                $user->save();
                // dd($request->all(), $user);
                return redirect()->route('sign_in_form')->with(['status' => 'success', 'message' => "Password updated successfully."]);
            } else {
                return redirect()->back()->withInput()->withErrors(['otp' => 'The provided OTP is incorrect.']);
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['email' => 'The provided email is incorrect.']);
        }
    } else {
        return redirect()->back();
    }
}


    public function profile_setting(ProfileRequest $request)
    {
        $user = auth()->user();

        // Check if user has permission to access settings
        if (!$user->hasPermissionTo('setting')) {
            return redirect()->back();
        }
        DB::beginTransaction();
        try {
            $updateUserData = [
                'name' => ucwords($request->name),
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $user->image, // Set the existing picture by default
                'created_by' => $user->id,
            ];

            if ($request->hasFile('user_pic')) {
                $image = $request->file('user_pic');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('user_images', $imageName, 'public');
                $updateUserData['image'] = 'user_images/' . $imageName;
            }
            $user->update($updateUserData);
            // Update the bio in the `userprofile` table
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $request->phone,
                    'short_bio' => $request->short_bio
                ]
            );
            // Update the address in the `useraddress` table
            $user->address()->updateOrCreate(
                ['user_id' => $user->id],
                ['address' => $request->address]
            );
            DB::commit();

            $message = "profile" . ($user->id ? "Updated" : "Saved") . " Successfully";
            return redirect()->route('admin.profileSetting')->with(['msg' => $message]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to update profile.');
        }
    }

    public function password_change(PasswordChangeRequest $request)
    {
        $user = auth()->user();

        // Use Spatie to check if the user has permission to change the password
        if (!$user->can('update_setting')) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to perform this action.']);
        }

        // Check if the current password matches the user's current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->updated_by = $user->id;
        $user->save();

        // Notify and redirect with success message
        $message = "Password updated successfully.";
        notify()->success($message);

        return redirect()->route('admin.profileSetting')->with(['msg' => $message]);
    }
}
