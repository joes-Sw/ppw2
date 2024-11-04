@extends('layouts.main')

@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 10px;"></button>
</div>
@endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Age</th>
                <th class="text-center">Level</th>
                <th class="text-center">Photo</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td class="text-center">{{ $item->name }}</td>
                    <td class="text-center">{{ $item->email }}</td>
                    <td class="text-center">{{ $item->age }}</td>
                    <td class="text-center">{{ $item->level }}</td>
                    <td class="text-center">
                        <img src="{{ asset('storage/' . $item->photo) }}" class="rounded" style="width: 150px">
                    </td>
                    <td class="text-center">
                        <button class="btn btn-success p-2 px-3 edit-btn" type="submit" onclick="document.location='{{route('user.edit', $item->id)}}'">
                            <img src="{{ asset('images/edit icon.png') }}" class="me-2">Edit
                        </button>
                        <button class="btn btn-danger p-2 px-3 delete-btn" type="submit" onclick="document.location='{{route('user.destroy', $item->id)}}'">
                            <img src="{{ asset('images/delete icon.png') }}" class="me-2">Hapus
                    </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Pagination --}}
    <div class="d-flex justify-content-end">
        {{ $data->links() }}
    </div>
</div>
@endsection
