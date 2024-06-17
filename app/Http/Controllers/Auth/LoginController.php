<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the incoming request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve the user
        $user = User::where('email', $credentials['email'])->first();

        // Check if the user exists and the password is correct
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Log the user in
            Auth::login($user);

            // Verify if the user is authenticated
            if (Auth::check()) {
                return redirect()->intended('/gallery');
            }
        }

        // Handle authentication failure
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    public function logout(Request $request){
        auth()->logout();
        return redirect('/');
    }
}
