<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => "required|string|email",
            'password' => "required|min:4",
        ]);
       $user = User::query()->where('email', $request->email)->first();
       if (!$user){
           return redirect()->back()->with('error', "Email not found");
       }
        if (!Hash::check($request->password, $user->password)){
            return redirect()->back()->with('error', "wrong password");
        }
        auth()->login($user);
        return redirect()->route('updateProfile')->with('success', "You are logged in");
    }
    public function registerView()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => "required|string",
            'email' => "required|string|email",
            'password' => "required|min:4",
            'confirm_password' => "required|same:password"
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        auth()->login($user);
        return redirect()->route('updateProfile')->with('success', "You are registered in");;
    }

    public function profileView()
    {
        return view('auth.updateProfile');
    }
    public function updateProfile(Request $request)
    {
        $val = Validator::make($request->all(), [
            'name' => "required|string",
            'email' => "required|string|email",
            'password' => "nullable|min:4",
        ]);
        if ($val->fails()){
            return redirect()->back()->withErrors($val);
        }
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->update();
        return redirect()->back()->with('success', "Updated successfully");
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You logged out');
    }
}
