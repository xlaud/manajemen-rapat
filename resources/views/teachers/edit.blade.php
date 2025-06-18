@extends('layouts.app')

@section('content')
    {{-- Memanggil komponen form guru untuk mode 'edit' --}}
    {{-- Variabel $teacher diasumsikan sudah dilewatkan dari controller --}}
    @include('teachers.form', ['mode' => 'edit', 'teacher' => $teacher])
@endsection