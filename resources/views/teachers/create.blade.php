@extends('layouts.app')

@section('content')
    {{-- Memanggil komponen form guru untuk mode 'create' (tambah baru) --}}
    @include('teachers.form', ['mode' => 'create'])
@endsection