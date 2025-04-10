@extends('componentes.nav')
@push('styles')
    @vite(['resources/css/home.css'])
@endpush
@section('content')
    <div class="background">
        <div class="container">
            <h1>Seja bem vindo ao site da barbearia</h1>
            <div class="collection">
                <div class="sub-container">
                    <div class="card"><h1>Agendamento</h1></div>
                    <div class="card"><h1>Catalogo cortes</h1></div>
                    <div class="card"><h1>Horarios</h1></div>
                    <div class="card"><h1>Contato</h1></div>
                    <div class="card"><h1>Sobre</h1></div>
                    <div class="card"><h1>Avisos</h1></div>                   
                </div>
            </div>
        </div>
    </div>
@endsection