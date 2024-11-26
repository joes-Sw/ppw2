<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use App\Models\PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = array(
        //     'id' => 'posts',
        //     'menu' => 'Gallery',
        //     'galleries' => PostModel::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(5)
        // );
        $data2 = DB::table('posts')->whereNotNull('picture')->paginate(5);
        return view('pertemuan4.posts', compact('data2'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pertemuan11.creategallery');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
    
        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png';
        }
    
        // dd($request->input());
        $post = new PostModel;
        $post->picture = $path;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();
    
        return redirect()->route('gallery.index')->with('success', 'Berhasil menambahkan data baru');
    }
    

    /**
     * Display the specified resource.
     */
    private function getpost($id)
    {
        return collect(PostModel::where('id', $id)->get())->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = $this->getpost($id);
        return view('pertemuan11.editgallery', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'string|max:150',
            'photo' => 'mimes:jpeg,jpg,png|max:3096'
        ]);

        if ($request->file('picture')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
            
            $data = [
                'id' => $request->id,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'picture' => $path,
            ];

        } else {
            $data = [
                'id' => $request->id,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ];
        }
        $update_posts = PostModel::where('id', '=', $id)->update($data);

        if ($update_posts) {
            return redirect()->route('gallery.index')->with('success', 'berhasil mengubah data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $foto = PostModel::where('id', $id)->first()->picture;
        Storage::delete($foto);
        $delete_post = PostModel::where('id', $id)->delete();
        return back()->with('success', 'Berhasil Menghapus Data');
    }

    /**
     * @OA\Get(
     *     path="/api/gallery",
     *     tags={"Gallery"},
     *     summary="Get list of books pictured",
     *     description="Mengambil daftar buku yang ada gambar",   
     * @OA\Response(
     *         response=200,
     *         description="Sukses mendapatkan data buku",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="status", type="boolean", example=true),
     *                 @OA\Property(property="message", type="string", example="Berhasil mendapatkan semua buku"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         properties={
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="title", type="string", example=" midnight library"),
     *                             @OA\Property(property="description", type="string", example="this is library"),
     *                             @OA\Property(property="picture", type="string", example="image_url.jpg")
     *                         }
     *                     )
     *                 ),
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function bookAPI()
    {
        $data_buku = PostModel::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->get();

        // Mereturn respons dalam format JSON
        return response()->json([
            'status' => true,
            'message' => "Berhasil mendapatkan semua buku",
            'data' => $data_buku,
        ], 200);
    }

}
