<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Auth attempt (langsung)
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // optional: kalau kamu butuh popup first login
            $request->session()->put('first_login', true);

            // ✅ ADMIN FIRST (PASTIIN PAKAI is_admin)
            if ($user->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            // ✅ USER biasa berdasarkan subscription_plan
            if ($user->subscription_plan === 'starter') {
                return redirect()->route('dashboard.premium.starter');
            }

            if ($user->subscription_plan === 'starter_plus') {
                return redirect()->route('dashboard.premium.starter.plus');
            }

            return redirect()->route('dashboard.user');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        Log::info('Registration attempt:', $request->all());

        $google = session('google_register');
        $isGoogle = !empty($google);

        if ($isGoogle) {
            $request->merge([
                'nickname' => $google['name'] ?? $request->nickname,
                'username' => $google['username'] ?? $request->username,
                'email'    => $google['email'] ?? $request->email,
            ]);
        }

        $rules = [
            'nickname' => 'required|string|max:50',
            'username' => 'required|string|max:30|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'current_weight' => 'required|numeric|min:30|max:300',
            'target_weight'  => 'required|numeric|min:30|max:300',
        ];

        if ($isGoogle) {
            $rules['password'] = 'nullable|min:8|confirmed';
        } else {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        try {
            $passwordHash = !empty($validated['password'])
                ? Hash::make($validated['password'])
                : Hash::make(Str::random(40));

            $user = User::create([
                'nickname' => $validated['nickname'],
                'username' => $validated['username'],
                'email'    => $validated['email'],
                'password' => $passwordHash,
                'current_weight' => $validated['current_weight'],
                'target_weight'  => $validated['target_weight'],
                'subscription_plan' => 'free',

                // ✅ admin flag default false
                'is_admin' => false,

                // google fields
                'google_id' => $isGoogle ? ($google['google_id'] ?? null) : null,
                'avatar'    => $isGoogle ? ($google['avatar'] ?? null) : null,
            ]);

            Auth::login($user);
            $request->session()->regenerate();
            $request->session()->put('first_login', true);

            if ($isGoogle) {
                session()->forget('google_register');
            }

            return redirect()
                ->route('subscription.plans')
                ->with('success', 'Registrasi berhasil! Silakan pilih paket langganan.');
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
