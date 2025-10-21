<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; 
use App\Models\User;
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

    /**
     * Handle registration submission.
     */
    public function register(Request $request)
    {
        // 🚨 LOG 1: Check if the request reached the controller and what data it contains
        Log::info('Registration attempt started.', $request->all());

        try {
            // Validate form input
            $request->validate([
                'first_name'  => 'required|string|max:100',
                'middle_name' => 'nullable|string|max:100',
                'last_name'   => 'required|string|max:100',
                'email'       => 'required|email|max:150|unique:users,email',
                'password'    => 'required|string|min:8|confirmed',
                'g-recaptcha-response' => 'required',
            ]);
            
            // Verify Google reCAPTCHA
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
            ]);

            $responseBody = $response->json();

            if (!$responseBody['success']) {
                return back()->withErrors(['g-recaptcha-response' => 'Captcha verification failed. Please try again.'])->withInput();
            }

            // 🚨 LOG 2: Check if validation passed
            Log::info('Registration validation passed for email: ' . $request->email);

            // Create a new user
            $user = User::create([
                'first_name'  => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name'   => $request->last_name,
                'email'       => $request->email,
                'password'    => Hash::make($request->password),
                'qr_code'     => null,
                'user_type'   => 'guest',
                'is_verified' => false,
            ]);
            
            // 🚨 LOG 3: Check if user creation was successful
            Log::info('User created successfully. ID: ' . $user->id);

            // Automatically log in the user (optional)
            Auth::login($user);
            
            // 🚨 LOG 4: Check successful login and redirection
            Log::info('User logged in and redirecting to home.');

            return redirect()->route('home')->with('success', 'Account created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // 🚨 LOG CATCH 1: Log validation errors
            Log::warning('Registration validation failed for email: ' . $request->email, ['errors' => $e->errors()]);
            throw $e; // Re-throw the exception to allow Laravel to handle flashing errors back
        } catch (\Throwable $e) {
            // 🚨 LOG CATCH 2: Catch any other unexpected errors
            Log::error('Registration failed with an unexpected error.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            // You might redirect with a generic error message here
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred during registration.');
        }
    }
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login submission.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

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

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
