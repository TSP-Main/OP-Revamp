<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Mail\OTPMail;
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
    public function registerUser(RegisterUserRequest $request)
    {
        if (!auth()->check()) {
            DB::transaction(function () use ($request) {
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
                }

                // Handle redirection
                $intendedUrl = session('intended_url');
                session()->forget('intended_url');
                return redirect($intendedUrl ? route('web.consultationForm') : '/admin');
            });

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

    public function login(LoginUserRequest $request)
    {
        // Check if user is already authenticated
        if (auth()->check()) {
            return $this->redirectBasedOnRole(auth()->user());
        }

        $credentials = $request->only('email', 'password');

        // Find the user by email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return redirect()->back()->with([
                'status' => 'noexistence',
                'message' => 'User does not exist',
                'email' => $credentials['email']
            ], 401);
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

    protected function redirectBasedOnRole($user)
    {
        // Redirect users based on their role using Spatie
        if ($user->hasRole('super_admin')) {
            return redirect('/admin');
        }

        if ($user->hasRole('dispensary')) {
            return redirect('/admin');
        }

        if ($user->hasRole('doctor')) {
            return redirect('/admin');
        }

        if ($user->hasRole('user')) {
            $intendedUrl = session('intended_url');
            session()->forget('intended_url');
            return $intendedUrl ? redirect()->route('web.consultationForm') : redirect('/admin');
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

    public function verify_otp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8',
        ]);

        $user = auth()->user();
        if (!$user) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if ($user->otp == trim($request->otp)) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                    return redirect()->route('login')->with(['status' => 'success', 'message' => "Password updated successfully."]);
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

}
