<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;  // Pastikan menggunakan Auth facade

class RegisterController extends Controller
{
    /**
     * Menampilkan form registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Menangani pendaftaran pengguna baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi data registrasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15',  // Nomor telepon
            'address' => 'required|string|max:255',  // Alamat
            'password' => 'required|string|min:8|confirmed',  // Kata sandi
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],  // Menyimpan nomor telepon
            'address' => $validated['address'],  // Menyimpan alamat
            'password' => Hash::make($validated['password']),  // Menyimpan kata sandi yang sudah di-hash
        ]);

        // Login pengguna setelah berhasil registrasi
        Auth::login($user);  // Menggunakan Auth::login untuk login otomatis

        return redirect('/dashboard');  // Arahkan ke halaman dashboard setelah login
    }
}
