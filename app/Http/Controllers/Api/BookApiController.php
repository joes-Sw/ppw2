<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bookresource;
use App\Models\BukuModel;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    function index() {
        $buku = BukuModel::all();
        return response()->json(["data" => Bookresource::collection($buku)], 200);
    }


    public function show($id)
    {
        $book = BukuModel::find($id);

        if (!$book) {
            return response()->json(["message" => "Book not found"], 404);
        }

        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = BukuModel::find($id);

        // Check if the book exists
        if (!$book) {
            return response()->json(["message" => "Book not found"], 404);
        }

        // Delete the book
        $book->delete();

        // Return success message
        return response()->json(["message" => "Book deleted successfully"], 200);
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        // Membuat buku baru
        $book = BukuModel::create([
            'judul' => $validatedData['title'],
            'penulis' => $validatedData['author'],
            'tgl_terbit' => $validatedData['published_at'],
        ]);

        // Mengembalikan respons sukses
        return response()->json([
            'message' => 'Book created successfully',
            'data' => new Bookresource($book),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Cari buku berdasarkan ID
        $book = BukuModel::find($id);

        // Jika buku tidak ditemukan, kembalikan respons not found
        if (!$book) {
            return response()->json(["message" => "Book not found"], 404);
        }

        // Validasi data yang diterima
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        // Perbarui data buku dengan data yang diterima
        $book->update(array_filter($validatedData));

        // Kembalikan respons sukses
        return response()->json([
            "message" => "Book updated successfully",
            "data" => new Bookresource($book),
        ], 200);
    }

    

}
