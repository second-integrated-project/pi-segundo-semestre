@extends('componentes.nav')
@push('styles')
    @vite(['resources/css/home.css'])
@endpush
@section('content')
    <div class="background">
        <div class="container">
            <h1 class="titulo">Seja bem vindo ao site da Armarillo Barber & Beer </h1>
            <div class="collection">
                <div class="sub-container">
                    <div class="card"><h1>Agendamento</h1></div>
                    <div class="card"><h1>Meus Agendamentos</h1></div>
                    <div class="card"><h1>Cartão fidelidade</h1></div>
                    <div class="card"><h1>Perfil</h1></div>
                    <div class="card"><h1>Informações contato</h1></div>                   
                </div>
            </div>
        </div>
    </div>
@endsection