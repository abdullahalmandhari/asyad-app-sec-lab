<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthDemoController extends Controller
{

  /*  public function login(Request $request)
    {
        $user = User::where('email', $request->email)
                    ->where('password', md5($request->password))
                    ->first();

        if ($user) {
            Auth::login($user);
            return redirect('/dashboard')->with('status', 'Logged in');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])
                     ->withInput();
    }

    
   */ public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect('/dashboard')->with('status', 'Logged in');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])
                     ->withInput();
    }
}
