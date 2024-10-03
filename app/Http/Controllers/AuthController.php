<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\PasswordChangeRequest;
use App\Http\Requests\Auth\ProfileRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\OtpVerifiedRequest;
use App\Mail\OTPMail;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Traits\MenuCategoriesTrait;


class AuthController extends Controller
{
    use MenuCategoriesTrait;

    public function registerUser(RegisterUserRequest $request)
    {
        $this->shareMenuCategories();
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
                        'password' => Hash::make($request->password),
                        'status' => $this->status['Active'] ?? '',
                        'is_active' => $this->status ?? '',
                        'created_by' => Auth::id() ?? 1,
                    ]
                );
                if (!$user) {
                    throw new \Exception('User creation failed');
                }
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
                        'zip_code' => $request->zip_code,
                        'state' => $request->state,
                        'country' => $request->country,
                    ]
                );

                // Log in the user if authentication is successful
                if (Auth::attempt($request->only('email', 'password'))) {
                    try {
                        $token = auth()->user()->createToken('MyApp')->plainTextToken;
                    } catch (\Exception $e) {
                        return redirect()->back()->withErrors('Token creation failed: ' . $e->getMessage());
                    }
                    DB::commit();

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

    public function registration_form()
    {
        $this->shareMenuCategories();
        $data['user'] = auth()->user() ?? [];
        if (auth()->user()) {
            return redirect('/admin');
        } else {
            return view('web.pages.registration_form', $data);
        }
    }

    public function loginForm()
    {
        $this->shareMenuCategories();
        return view('web.pages.login');
    }

    public function login(LoginUserRequest $request)
    {
        try {
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json('User login failed', 406);
            }

            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;

            return $this->redirectBasedOnRole($user);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error', 'Something went wrong, error in processing email'], 406);
        }
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->hasRole('user')) {
            $intendedUrl = session('intended_url');
            session()->forget('intended_url');
            return $intendedUrl ? redirect()->route('web.consultationForm') : redirect('/dashboard');
        }

        return redirect('/dashboard');
    }

    public function logout()
    {
        $user = auth()->user();

        // Log out the user first, and invalidate the session
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken(); // Protect against CSRF

        // Role-based redirection
        if ($user->hasRole('user')) {
            return redirect('/');
        }

        return redirect('/sign-in');
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

    public function profileSettingPage()
    {
        // profile setting page
        $user = auth()->user();
        $data['user'] = $user;
        return view('admin.pages.profile_setting', $data);
    }
    public function profile_setting(ProfileRequest $request)
    {
        $user = auth()->user();
        $this->authorize('setting');

        DB::beginTransaction();
        try {
            $updateUserData = [
                'name' => ucwords($request->name),
                'email' => $request->email,
                'created_by' => $user->id,
            ];

            // Handle profile picture upload
            if ($request->hasFile('user_pic')) {
                $image = $request->file('user_pic');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('user_images', $imageName, 'public');
                $updateUserData['image'] = 'user_images/' . $imageName;
            }

            // Update or create profile details
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'speciality' => $request->speciality ?? '',
                    'phone' => $request->phone ?? '',
                    'image' => $updateUserData['image'] ?? $user->profile->image, // Ensure new image is considered
                    'short_bio' => $request->short_bio ?? '',
                ]
            );

            // Update or create address details
            $user->address()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => $request->address ?? '',
                    'apartment' => $request->apartment ?? '',
                    'city' => $request->city ?? '',
                    'state' => $request->state ?? '',
                    'zip_code' => $request->zip_code ?? '',
                    'country' => $request->country ?? '',
                ]
            );

            // Update user base details
            $user->update($updateUserData);

            DB::commit();

            $message = "Profile " . ($user->wasChanged() ? "Updated" : "Saved") . " Successfully";
            return redirect()->route('web.dashboard')->with('msg', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function password_change(PasswordChangeRequest $request)
    {
        $user = auth()->user();

        // Check if the current password matches the user's current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => ['current_password' => ['The current password is incorrect.']
                ]
            ], 422);
        }


        // Update password
        $user->password = Hash::make($request->password);
        $user->updated_by = $user->id;
        $user->save();

        // Notify and return success message
        $message = "Password updated successfully.";
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

}
