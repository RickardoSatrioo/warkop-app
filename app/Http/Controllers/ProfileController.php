<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil dengan data pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),  // Mengambil data pengguna yang sedang login
        ]);
    }

    /**
     * Memperbarui data profil pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',  // Opsional, hanya diperbarui jika diisi
        ]);

        $user = Auth::user();

        // Update informasi pengguna
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,  // Update password jika diisi
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Menghapus akun pengguna.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        // Menghapus akun pengguna yang sedang login
        Auth::user()->delete();

        // Setelah penghapusan, arahkan ke halaman utama
        return redirect('/')->with('success', 'Akun berhasil dihapus');
    }
}
