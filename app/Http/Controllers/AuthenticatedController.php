<?php

namespace App\Http\Controllers;

use Rules\Password;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticatedController extends Controller
{
    // function untuk login page
    public function loginCreate() {
        return view('layouts.guest.login', [
            "title" => "Login",
        ]);
    }
    public function registerCreate() {
        return view('layouts.guest.register', [
            "title" => "Registrasi",
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
        if (Auth::user()->role === 'Pengguna') {
            return redirect()->route('landing.page');
        }else{
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }
    public function registerStore(Request $request){
        try {
            DB::beginTransaction();
            $validators = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|string|email|unique:users,email',
                'username' => 'required|string',
                'password' => 'required',
            ]);
            if ($validators->fails()) {
                return back()->with('error', $validators->errors()->first())->withInput($request->except('password'));
            }
    
            $pw = Hash::make($request->password);
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = $pw;
            $user->save();

            DB::commit();
            return redirect()->route('login')->with('success', 'Registrasi berhasil, silahkan login menggunakan akun anda');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', substr($th->getMessage(), 0, 200));
        }
    }

    public  function destroy(Request $request): RedirectResponse {
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();

        $request->session()->regenerate();

        return redirect('/');
    }
}
