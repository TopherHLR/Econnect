<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; 
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginNotificationMail; 
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Log; 

class AuthController extends Controller 
{
    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.signup');
    }
    public function sendVerificationCode(Request $request)
    {
        Log::info('📩 STEP 1: sendVerificationCode() called', $request->all());

        try {
            // STEP 2 — Validate inputs
            Log::info('📋 STEP 2: Starting validation');
            $validated = $request->validate([
                'first_name'  => 'required|string|max:100',
                'middle_name' => 'nullable|string|max:100',
                'last_name'   => 'required|string|max:100',
                'email'       => 'required|email|max:150|unique:users,email',
                'password'    => 'required|string|min:8|confirmed',
            ]);
            Log::info('✅ STEP 2: Validation passed', $validated);

            // STEP 3 — Generate verification code
            $code = rand(100000, 999999);
            Log::info("🔢 STEP 3: Generated verification code: {$code}");

            // STEP 4 — Store pending registration in session
            Log::info('💾 STEP 4: Storing pending registration in session');
            Session::put('pending_registration', array_merge($validated, [
                'verification_code' => $code,
            ]));
            Log::info('✅ STEP 4: Session data stored successfully');

            // STEP 5 — Send verification email
            Log::info('📧 STEP 5: Preparing to send email to ' . $validated['email']);
            Mail::to($validated['email'])->send(new VerificationCodeMail((object)[
                'first_name' => $validated['first_name'],
                'verification_code' => $code,
            ]));
            Log::info('✅ STEP 5: Verification email sent successfully');

            // STEP 6 — Redirect to verification form
            Log::info('➡️ STEP 6: Redirecting to verify.email.form route');
            return redirect()->route('verify.email.form')
                ->with('info', 'A verification code has been sent to your email.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('❌ VALIDATION FAILED', ['errors' => $e->errors()]);
            throw $e;

        } catch (\Illuminate\Mail\Mailable $e) {
            Log::error('📮 MAIL ERROR', ['error' => $e->getMessage()]);

            return back()->with('error', 'Failed to send verification email. Please try again.');

        } catch (\Throwable $e) {
            Log::error('💥 UNEXPECTED ERROR', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Something went wrong during registration.');
        }
    }

    public function showVerificationForm()
    {
        if (!Session::has('pending_registration')) {
            return redirect()->route('register')->with('error', 'Please fill out the registration form first.');
        }
        return view('auth.verify-email');
    }

    public function verifyAndCreate(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $pending = Session::get('pending_registration');

        if (!$pending || $request->code != $pending['verification_code']) {
            return response()->json(['error' => 'Invalid verification code.'], 422);
        }

        // 🧩 Create user after successful verification
        $user = \App\Models\User::create([
            'first_name'  => $pending['first_name'],
            'middle_name' => $pending['middle_name'],
            'last_name'   => $pending['last_name'],
            'email'       => $pending['email'],
            'password'    => Hash::make($pending['password']),
            'is_verified' => true,
        ]);

        // 🧩 Log the user in immediately
        Auth::login($user);

        // 🧩 Clear pending registration
        Session::forget('pending_registration');

        return redirect()->route('home')->with('success', 'Account verified and logged in successfully!');
    }


    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 📨 Send Gmail notification
            try {
                Mail::to($user->email)->send(new LoginNotificationMail($user));
                Log::info("📧 Login notification email sent to {$user->email}");
            } catch (\Throwable $e) {
                Log::error("❌ Failed to send login notification email: " . $e->getMessage());
            }

            return redirect()->route('home')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }
    /**
     * Logout the user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }
}
