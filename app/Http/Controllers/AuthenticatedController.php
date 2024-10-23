<?php

namespace App\Http\Controllers;

use Rules\Password;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedController extends Controller
{
    // function untuk login page
    public function loginCreate() {
        return view('layouts.guest.login', [
            "title" => "Login",
        ]);
    }

    public function loginStore(Request $request) : RedirectResponse{

        $credentials = $request->validate([
            'username'  => 'required|string',
            'password'  => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Username atau password salah')->withInput();
        }
        
        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public  function destroy(Request $request): RedirectResponse {
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();

        $request->session()->regenerate();

        return redirect('/');
    }
}
