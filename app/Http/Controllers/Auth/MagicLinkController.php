<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class MagicLinkController extends Controller
{
    // Menampilkan form masukkan email
    public function create(): View
    {
        return view('auth.login-link');
    }

    // Membuat tautan bertanda tangan lalu mengirimnya lewat email
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $link = URL::temporarySignedRoute(
                'login.link.verify',
                now()->addMinutes(15),
                ['user' => $user->id]
            );

            Mail::raw(
                "Klik tautan berikut untuk masuk (berlaku 15 menit):\n\n" . $link,
                function ($message) use ($user) {
                    $message->to($user->email)->subject('Tautan Masuk Akun Anda');
                }
            );
        }

        // Pesan yang sama untuk email terdaftar maupun tidak, supaya email pengguna tidak bisa ditebak
        return back()->with('status', 'Jika email terdaftar, tautan masuk sudah dikirim. Periksa kotak masuk Anda.');
    }

    // Memverifikasi tautan lalu memasukkan pengguna ke sesi
    public function login(Request $request, User $user): RedirectResponse
    {
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }
}