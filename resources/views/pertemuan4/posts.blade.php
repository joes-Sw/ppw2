@extends('layouts.main')

@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 10px;"></button>
</div>
@endif
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <button class="btn btn-primary mb-3" onclick="window.location='{{ route('gallery.create') }}'">
            <img src="{{ asset('images/tambah resep icon.png') }}" class="me-2">Tambah Data
        </button>
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body" id="gallery">
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Picture</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data2 as $index => $item)
                            <tr>
                                <td>{{ $data2->firstItem() + $index }}</td>
                                <td class="text-center">{{ $item->title }}</td>
                                <td class="text-center">{{ $item->description }}</td>
                                <td class="text-center">
                                    <a href="{{ asset('storage/' . $item->picture) }}" class="example image-link" data-lightbox="roadtrip" data-title="{{ $item->description }}">
                                    <img src="{{ asset('storage/' . $item->picture) }}" class="rounded" style="width: 150px"> </a>
                                </td>
                                <td class="text-center">
                                    
                                    <button class="btn btn-success p-2 px-3 edit-btn" type="submit" onclick="document.location='{{route('gallery.edit', $item->id)}}'">
                                        <img src="{{ asset('images/edit icon.png') }}" class="me-2">Edit
                                    </button>
                                    <button class="btn btn-danger p-2 px-3 delete-btn" data-bs-toggle="modal"
                                    data-bs-target="#HapusObatModal{{ $item->id }}">
                                    <img src="{{ asset('images/delete icon.png') }}" class="me-2">Hapus
                                </button>
                                </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak Ada Data</td>
                            </tr>
                            @endforelse
                    <div class="d-flex">
                        {{ $data2->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($data2 as $key)
        <div class="modal fade" id="HapusObatModal{{ $key->id }}" tabindex="-1" aria-labelledby="HapusObatModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="HapusObatModalLabel">Hapus Data </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('images/warning icon.png') }}" alt="Warning">
                        <p>Anda yakin ingin menghapus data ini?</p>
                        <form action="{{ route('gallery.destroy', $key->id)}}" method="POST">
                        <div class="d-flex justify-content-around mt-3">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">TIDAK</button>
                              @csrf
                              @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4">YA</button>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $.get('http://localhost:8000/api/gallery', function(response) {
            console.log('Response dari API:', response);
            if (response['data']) {
                var html = '';
                response['data'].forEach(function(gallery) {
                    html += `
                        <div class="col-sm-2">
                            <div>
                                <a class="example-image-link" href="/storage/${gallery.picture}" data-lightbox="roadtrip" data-title="${gallery.description}">
                                    <img class="example-image img-fluid mb-2" src="/storage/${gallery.picture}" alt="${gallery.title}" width="200" />
                                </a>
                            </div>
                        </div>`;
                });
                console.log('HTML yang akan dimasukkan:', html);
                $('#gallery').html(html);
            } else {
                $('#gallery').html('<h3>Tidak ada data.</h3>');
            }
            }).fail(function() {
                console.error('Gagal memuat data dari API.');
                $('#gallery').html('<h3>Gagal memuat data dari API.</h3>');
            });
        });
    </script>

@endsection
   
