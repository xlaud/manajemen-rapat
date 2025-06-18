@extends('layouts.app')

@section('content')
    {{-- Memuat form partial dengan mode 'create' --}}
    @include('agendas.form', ['mode' => 'create'])
@endsection