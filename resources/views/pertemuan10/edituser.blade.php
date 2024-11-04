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
        <form action="{{ route('user.update', $edit->id) }}" method="POST" style="width: 400px;"
            enctype="multipart/form-data">
            @csrf
            <h2 class="text-center">Edit Buku</h2>
            <input type="hidden" class="form-control" id="id" name="id" value="{{ $edit->id }}">

            <div class="mb-3">
                <label for="name" class="form-label">name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ $edit->name }}" required>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $edit->email }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">age</label>
                <input type="number" class="form-control" id="age" name="age" value="{{ $edit->age }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="hidden" name="oldImage" value="{{ $edit->photo }}">
                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo"
                    name="photo" value="{{ $edit->photo }}">
                @if ($errors->has('photo'))
                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                @endif
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update Users</button>
            </div>
        </form>
    </div>
@endsection
