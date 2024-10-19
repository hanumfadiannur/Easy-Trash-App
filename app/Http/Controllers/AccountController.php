<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function loading()
    {
        return view('start');
    }

    public function register()
    {
        return view('account.register');
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'phonenumber' => 'required',
            'role' => 'required|in:user,recycleorg',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        // Register user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phonenumber = $request->phonenumber;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('account.login')->with('success', 'You have registered succesfully.');
    }

    public function login()
    {
        return view('account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'role' => 'required|in:user,recycleorg',
            'password' => 'required'


        ]);

        if ($validator->fails()) {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('account.profile');
        } else {
            return redirect()->route('account.login')->with('error', 'Either email or password is incorrect.');
        }
    }
}
