@extends('layouts.main')
@section('title', 'Halaman About')

@section('content')

<h1>Ini adalah halaman about</h1>
<h1>{{ $name }}</h1>
<h1>{{ $email }}</h1>
@endsection