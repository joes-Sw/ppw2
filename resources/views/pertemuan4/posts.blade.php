@extends('layouts.main')

@section('content')
<p>ini adalah halaman posts (yang dapat diakses oleh level admin dan level lainnya)</p>
@foreach ($data as $item)
    <p>{{ $item }}</p>
@endforeach
@endsection
   
