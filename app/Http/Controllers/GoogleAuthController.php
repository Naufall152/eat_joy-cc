<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        // Kalau kamu sering dapat error state/session, stateless lebih stabil
        // tapi kalau sudah aman tanpa stateless, boleh hapus stateless di sini.
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            // ✅ stateless biar tidak random error "Invalid state" / session mismatch
            $googleUser = Socialite::driver('google')->stateless()->user();

            $email = $googleUser->getEmail();

            if (!$email) {
                return redirect()->route('login')
                    ->withErrors(['error' => 'Google tidak mengirim email. Pastikan izin email diberikan.']);
            }

            // ✅ Cari user by email dulu
            $user = User::where('email', $email)->first();

            // =========================
            // MODE: REGISTER VIA GOOGLE
            // =========================
            if (!$user) {
                // bikin username aman
                $raw = $googleUser->getNickname() ?: $googleUser->getName() ?: 'user';

                $baseUsername = Str::of($raw)
                    ->lower()
                    ->replace(' ', '')
                    ->replace('.', '')
                    ->replace('-', '')
                    ->replace('_', '')
                    ->toString();

                $baseUsername = preg_replace('/[^a-z0-9]/', '', $baseUsername);
                if (!$baseUsername) $baseUsername = 'user';

                $username = $baseUsername;
                $i = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $baseUsername . $i;
                    $i++;
                }

                // ✅ Simpan data google ke session biar register page bisa auto-fill / skip step
                $request->session()->put('google_register', [
                    'google_id' => $googleUser->getId(),
                    'name'      => $googleUser->getName(),
                    'email'     => $email,
                    'avatar'    => $googleUser->getAvatar(),
                    'username'  => $username,
                ]);

                // arahkan ke register
                return redirect()->route('register');
            }

            // =========================
            // MODE: LOGIN VIA GOOGLE
            // =========================

            // update google_id & avatar kalau belum ada
            $needSave = false;

            if (empty($user->google_id)) {
                $user->google_id = $googleUser->getId();
                $needSave = true;
            }

            if (empty($user->avatar) && $googleUser->getAvatar()) {
                $user->avatar = $googleUser->getAvatar();
                $needSave = true;
            }

            if ($needSave) {
                $user->save();
            }

            // ✅ LOGIN + REGENERATE SESSION (INI YANG KRITIKAL)
            Auth::login($user, true);
            $request->session()->regenerate();
            request()->session()->put('first_login', true);

            if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
            }

            /**
             * first_login:
             * Kalau kamu set true di sini terus, nanti tiap login muncul popup first_login terus.
             * Aku bikin lebih aman:
             * - set first_login hanya kalau session belum pernah ditandai.
             *
             * Kalau kamu memang mau selalu muncul, silakan balikkan ke true terus.
             */
            if (!$request->session()->has('first_login_done')) {
                $request->session()->put('first_login', true);
                $request->session()->put('first_login_done', true);
            }

            // ✅ redirect sesuai subscription_plan (ikut logic kamu)
            if ($user->subscription_plan === 'starter') {
                return redirect()->route('dashboard.premium.starter');
            } elseif ($user->subscription_plan === 'starter_plus') {
                return redirect()->route('dashboard.premium.starter.plus');
            }

            return redirect()->route('dashboard.user');

        } catch (\Throwable $e) {
            Log::error('Google login callback error: ' . $e->getMessage());

            return redirect()->route('login')
                ->withErrors(['error' => 'Login Google gagal, coba lagi.']);
        }
    }
}
