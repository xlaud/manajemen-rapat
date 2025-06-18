@extends('layouts.app')

@section('content')
    {{-- Memuat form partial dengan mode 'edit' dan meneruskan data agenda yang akan diedit --}}
    @include('agendas.form', ['mode' => 'edit', 'agenda' => $agenda])
@endsection