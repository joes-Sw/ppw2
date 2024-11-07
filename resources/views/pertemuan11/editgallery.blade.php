@extends('layouts.main')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                style="position: absolute; right: 10px; top: 10px;"></button>
        </div>
    @endif

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <form action="{{ route('gallery.update', $edit->id) }}" method="POST" style="width: 400px;"
            enctype="multipart/form-data">
            @csrf
            <h2 class="text-center">Edit Buku</h2>
            <input type="hidden" class="form-control" id="id" name="id" value="{{ $edit->id }}">

            <div class="mb-3">
                <label for="title" class="form-label">title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ $edit->title }}" required>
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">description</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ $edit->description }}"required>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">picture</label>
                <input type="hidden" name="oldImage" value="{{ $edit->picture }}">
                <input type="file" class="form-control @error('picture') is-invalid @enderror" id="picture"
                name="picture" value="{{ $edit->picture }}">
                @if ($errors->has('picture'))
                <span class="text-danger">{{ $errors->first('picture') }}</span>
                @endif
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update Users</button>
            </div>
        </form>
    </div>
@endsection
