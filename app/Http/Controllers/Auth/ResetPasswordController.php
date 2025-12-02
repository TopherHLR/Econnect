<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();

                // 🟢 Automatically log the user in after password reset
                Auth::login($user);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $user = Auth::user();

            // ⭐ Send login notification email (optional, same as in login())
            try {
                Mail::to($user->email)->send(new LoginNotificationMail($user));
                Log::info("📧 Login notification email sent to {$user->email}");
            } catch (\Throwable $e) {
                Log::error("❌ Failed to send login notification email: " . $e->getMessage());
            }

            // ⭐ Match your existing login redirect logic
            if ($user->user_type === 'admin') {
                Log::info("👑 Admin {$user->email} logged in after password reset.");
                return redirect()->route('adminHome')->with('success', 'Password reset successful!');
            }

            Log::info("🙋 Regular user {$user->email} logged in after password reset.");
            return redirect()->route('home')->with('success', 'Password reset successful!');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

}
