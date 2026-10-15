<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SiswaAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.siswa-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'nama_lengkap' => 'required',
        ]);

        // Cari data siswa berdasarkan NIS dan Nama Lengkap
        $siswa = Siswa::where('nis', $request->nis)
            ->where('nama_lengkap', $request->nama_lengkap)
            ->first();

        if (! $siswa) {
            throw ValidationException::withMessages([
                'nis' => 'NIS atau Nama Lengkap yang Anda masukkan salah.',
            ]);
        }

        // Login menggunakan guard siswas
        Auth::guard('siswas')->login($siswa);
        $request->session()->regenerate();

        return redirect()->intended('/siswa');
    }

    public function logout(Request $request)
    {
        Auth::guard('siswas')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/siswa/login');
    }
}