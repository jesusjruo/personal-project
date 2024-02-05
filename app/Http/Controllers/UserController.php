<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => ['required' , 'min:3' , 'max:10' , Rule::unique('users' , 'name')],
            'email' => ['required' , 'email' , 'min:3', Rule::unique('users' , 'email')],
            'password' => ['required' , 'min:8' , 'max:200']
        ]);

        $fields['password'] = bcrypt($fields['password']);
        $user = User::create($fields);
        auth()->login($user);
        return redirect('/');  
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'login_name' => 'required',
            'login_password' => 'required'
        ]);

        if (auth()->attempt(['name' => $fields['login_name'] , 'password' => $fields['login_password']])) {
            $request->session()->regenerate();
        }

        return redirect('/');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }
}
