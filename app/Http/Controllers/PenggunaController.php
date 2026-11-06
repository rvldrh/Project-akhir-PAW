<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani autentikasi login pengguna.
     *
     * @throws ValidationException
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'identitas_akun' => ['required', 'string'],
            'kredensial' => ['required_without:password', 'nullable', 'string'],
            'password' => ['required_without:kredensial', 'nullable', 'string'],
        ], [
            'identitas_akun.required' => 'Identitas akun wajib diisi.',
            'kredensial.required_without' => 'Kata sandi wajib diisi.',
            'password.required_without' => 'Kata sandi wajib diisi.',
        ]);

        $plainPassword = $request->input('kredensial') ?? $request->input('password');

        $credentials = [
            'identitas_akun' => $request->input('identitas_akun'),
            'password' => $plainPassword,
        ];

        // Verifikasi kredensial menggunakan guard default
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'identitas_akun' => 'Identitas akun atau kata sandi yang Anda masukkan salah.',
            ]);
        }

        /** @var Pengguna $user */
        $user = Auth::user();

        // Aturan bisnis: hanya akun berstatus Aktif yang dapat mengakses sistem
        if (! $user->isAktif()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'identitas_akun' => 'Akun Anda berstatus nonaktif. Silakan hubungi petugas.',
            ]);
        }

        // Regenerasi session ID untuk mencegah session fixation
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Menangani proses logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah berhasil keluar dari sistem.');
    }

    /**
     * Mengarahkan pengguna ke dashboard yang sesuai berdasarkan perannya.
     */
    public function redirectByRole(): RedirectResponse
    {
        /** @var Pengguna|null $user */
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isSatpam()) {
            return redirect()->route('satpam.dashboard');
        }

        if ($user->isMahasiswa()) {
            return redirect()->route('mahasiswa.dashboard');
        }

        // Fallback jika peran tidak dikenal
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'identitas_akun' => 'Peran pengguna tidak valid.',
        ]);
    }
}
