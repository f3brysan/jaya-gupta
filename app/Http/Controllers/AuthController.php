<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{   

    public function login()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        
        $captcha = Hash::check($request->captcha, decrypt(Session::get('captcha.key')));
        if ($captcha) {
            $request->validate([
                'email' => ['required', 'email:dns'],
                'password' => ['required'],            
            ]);
    
            $credentials = $request->validate([
                'email' => ['required', 'email:dns'],
                'password' => ['required'],           
            ]);        
            
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();            
                $user = auth()->user();
                $bio = Biodata::where('id',$user->id)->first();            
                Session::put('user', $user);
                Session::put('bio', $bio);            
                return redirect()->intended('/')->with('success', 'Selamat Datang '.$bio->nama ?? $user->email. ' .');
            }
        }        
        return back()->with('LoginError', 'Email atau Password Anda salah !');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
