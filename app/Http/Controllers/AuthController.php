<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'buku'
        ]);
    }

    public function register()
    {
        $leveluser = User::all();
        return view('pertemuan8.register', compact('leveluser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users',
            'age' => 'required',
            'level' => 'required',
            'password' => 'required|min:2|confirmed',
            'photo' => 'mimes:jpeg,jpg,png|max:3096'
        ]);

        if($request->hasFile('photo')) {
            $filenamewithext = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenamewithext, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenamesimpan = $filename . '_' . time() . '_' . $extension;
            $path = $request->file('photo')->storeAs('photos', $filenamesimpan);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->input('age'),
            'level' => $request->input('level'),
            'password' => Hash::make($request->password),
            'photo' => $path
        ]);


        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('buku')->with('success', 'You have successfully registered & logged in');
    }

    public function login()
    {
        return view('pertemuan8.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('buku')->with('success', 'You have successfully logged in!');
        }
        return back()->withErrors(['email' => 'Your provided credentials do not match in our records'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('login')->with('success', 'You have logged out succesfully!');
    }
}
