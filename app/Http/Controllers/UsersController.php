<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index() {
        if(!Auth::check()) {
            return redirect()->route('login')->withErrors(['email' => 'Please Login To Access the dashboard'])->onlyInput('email');
        }
        $data = DB::table('users')->paginate(5);
        // dd($data);
        return view('pertemuan10.index', compact('data'));
    }

    private function getuser($id)
    {
        return collect(User::where('id', $id)->get())->firstOrFail();
    }

    public function edit(String $id) {
        $edit = $this->getuser($id);
        return view('pertemuan10.edituser', compact('edit'));
    }

    public function update(Request $request, String $id) {
        $request->validate([
            'name' => 'string|max:150',
            'photo' => 'mimes:jpeg,jpg,png|max:3096'
        ]);

        if ($request->file('photo')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            $filenamewithext = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenamewithext, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenamesimpan = $filename . '_' . time() . '_' . $extension;
            $path = $request->file('photo')->storeAs('photos', $filenamesimpan);
            
            $data = [
                'id' => $request->id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'age' => $request->input('age'),
                'photo' => $path,
            ];

        } else {
            $data = [
                'id' => $request->id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'age' => $request->input('age'),
            ];
        }
        $update_users = User::where('id', '=', $id)->update($data);

        if ($update_users) {
            return redirect()->route('user.index')->with('success', 'berhasil mengubah data');
        }
    }

    public function destroy(string $id) {
        $foto = User::where('id', $id)->first()->photo;
        Storage::delete($foto);
        $delete_user = User::where('id', $id)->delete();
        return back()->with('success', 'Berhasil Menghapus Data');
    }
}
