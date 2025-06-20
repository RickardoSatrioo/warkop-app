<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     * Mengarahkan pengguna berdasarkan role dan tujuan sebelumnya.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Prioritas utama: jika user adalah admin, selalu arahkan ke dashboard admin.
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        // ================= PERBAIKAN DI SINI =================
        // Untuk user lain, arahkan ke halaman yang mereka tuju sebelumnya (misal: /pesan).
        // Jika tidak ada halaman yang dituju, arahkan ke 'dashboard' sebagai default.
        return redirect()->intended(route('dashboard'));
        // ======================================================
    }
}
