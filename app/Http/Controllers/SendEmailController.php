<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;
use Mail;
use App\Mail\SendEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SendEmailController extends Controller
{
    public function index() {
        return view('pertemuan12.email');
    }

    public function store(Request $request)
    {
        $subject = 'Terimakasih Sudah Mendaftar, Akun Anda Sudah Berhasil Didaftarkan';
        // $data = [($request->name), ($request->email)];
        $data = ['name' => $request->name, 'email' => $request->email, 'created_at' => NOW(), 'subject' => $subject];
        // $data = $request->all();
        // $data['subject'] = $subject;
        
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

        dispatch(new SendEmailJob($data));
        // dispatch(new SendEmailJob($data));

        return redirect()->route('gallery.index')->with('success','Email Berhasil dikirim');
    }

    public function index1() {
        return view('pertemuan12.regiswithmail');
    }
}
