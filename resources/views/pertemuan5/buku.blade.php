@extends('layouts.main')

@section('content')
    
    <p>(hanya admin yang dapat melihat)</p>
    <a href="{{ route('buku.tambah') }}" class="btn btn-success">Tambah Buku</a>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif($message = Session::get('error'))
    <div class="alert alert-error alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

   <table class="table table-stripped">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Harga</th>
            <th>Tgl_terbit</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->penulis }}</td>
                <td>{{ "Rp.".number_format($item->harga, 2, ',', '.') }}</td>
                <td>{{ $item->tgl_terbit }}</td>
                <td>
                    <button type="submit" class="btn btn-warning"><a href="{{ route('buku.edit', $item->id) }}" style="text-decoration: none; color: white">Ubah</a></button>
                    <form action="/buku/{{ $item->id }}" method="POST">
                        @csrf 
                        @method('DELETE')
                        <button onclick="return confirm('Yakin ingin menghapus data?')" type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        
    </tbody>
   </table>
    
   <h2>Total Jumlah Data: {{ $total_data }}</h2>
   <h2>Total Harga Buku: {{ "Rp.".number_format($total_harga, 2, ',', '.') }}</h2>

@endsection