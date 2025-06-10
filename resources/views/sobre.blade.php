@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Nossa História') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-12 text-gray-800">

                    <div class="text-center mb-12">
                        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">
                            Amarillo Barber<span class="text-yellow-500"> n </span>Beer
                        </h1>
                        <p class="mt-4 text-xl text-gray-600">
                            Mais que uma barbearia, um ponto de encontro.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12 items-center">
                        <div>
                            <h3 class="text-2xl font-bold mb-4 border-l-4 border-yellow-500 pl-4">Missão</h3>
                            <p class="mb-4 text-lg">
                                Nossa missão é otimizar a experiência de cuidado masculino, unindo a precisão da barbearia clássica a um ambiente moderno e acolhedor. Buscamos a excelência não apenas no corte, mas na agilidade e na gestão do seu tempo, garantindo que cada visita seja uma experiência tranquila e produtiva.
                            </p>
                            <p>
                                Fundada em 2023 por entusiastas da arte da barbearia e da boa cerveja, a Amarillo nasceu do desejo de criar um espaço onde estilo, amizade e relaxamento coexistem.
                            </p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg shadow">
                             <h3 class="text-2xl font-bold mb-4 border-l-4 border-gray-800 pl-4">Nosso Endereço</h3>
                             <p class="text-lg font-semibold">Venha nos conhecer no coração de Indaiatuba.</p>
                             <p class="mt-2">
                                Mall do condomínio SKY, <br>
                                Avenida Presidente Vargas, 2881<br>
                                Indaiatuba - SP
                             </p>
                        </div>
                    </div>

                    <div class="mb-12">
                        <h3 class="text-3xl font-bold text-center mb-8">Nossos Pilares</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-yellow-500 p-4 rounded-full mb-3"><svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg></div>
                                <h4 class="font-bold text-lg">Qualidade</h4>
                                <p class="text-gray-600 text-sm">Técnica moderna, utilizamos apenas os melhores produtos para deixar você na regua.</p>
                            </div>
                            <div class="flex flex-col items-center">
                                 <div class="bg-gray-800 p-4 rounded-full mb-3"><svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                <h4 class="font-bold text-lg">Experiência</h4>
                                <p class="text-gray-600 text-sm">Um ambiente pensado para o seu conforto, com boa música, cerveja gelada e ótimas conversas.</p>
                            </div>
                            <div class="flex flex-col items-center">
                                 <div class="bg-yellow-500 p-4 rounded-full mb-3"><svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg></div>
                                <h4 class="font-bold text-lg">Tradição</h4>
                                <p class="text-gray-600 text-sm">Respeito pelas técnicas clássicas da barbearia, passadas de geração em geração.</p>
                            </div>
                             <div class="flex flex-col items-center">
                                 <div class="bg-gray-800 p-4 rounded-full mb-3"><svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg></div>
                                <h4 class="font-bold text-lg">Inovação</h4>
                                <p class="text-gray-600 text-sm">Sempre atentos às novas tendências para oferecer a você o que há de mais moderno.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-12 border-t border-gray-200">
                        <h3 class="text-3xl font-bold text-center mb-10">Conheça Nossos Barbeiros</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 items-start">

                            <div class="text-center">
                                <div class="mx-auto bg-gray-200 h-48 w-48 rounded-full mb-4 flex items-center justify-center">
                                    <img src="{{ asset('images/barbero1.jpg') }}"
                                        alt="Foto do barbeiro Ricardo Alves"
                                        class="h-full w-full rounded-full object-cover"
                                    />
                                </div>
                                <h4 class="text-2xl font-bold">Ricardo "O Navalha" Alves</h4>
                                <p class="text-yellow-600 font-semibold">Barbeiro Mestre & Fundador</p>
                                <p class="mt-3 text-gray-600">
                                    Com mais de 15 anos de experiência, Ricardo é um mestre das técnicas clássicas. Sua precisão com a navalha é lendária, e ele se especializa em barbas desenhadas e cortes tradicionais.
                                </p>
                            </div>

                            <div class="text-center">
                                <div class="mx-auto bg-gray-200 h-48 w-48 rounded-full mb-4 flex items-center justify-center">
                                    <img src="{{ asset('images/barbero2.jpg') }}"
                                        alt="Foto do barbeiro Ricardo Alves"
                                        class="h-full w-full rounded-full object-cover"
                                    />
                                </div>
                                <h4 class="text-2xl font-bold">Lucas "O Estilista" Martins</h4>
                                <p class="text-yellow-600 font-semibold">Especialista em Cortes Modernos</p>
                                <p class="mt-3 text-gray-600">
                                    Antenado com as últimas tendências, Lucas é o cara certo para cortes ousados, fades perfeitos e estilização. Se você busca um visual moderno e único, sua cadeira é o lugar certo.
                                </p>
                            </div>

                            <div class="text-center">
                                <div class="mx-auto bg-gray-200 h-48 w-48 rounded-full mb-4 flex items-center justify-center">
                                    <img src="{{ asset('images/cabeleireira.webp') }}"
                                        alt="Foto do barbeiro Ricardo Alves"
                                        class="h-full w-full rounded-full object-cover"
                                    />
                                </div>
                                <h4 class="text-2xl font-bold">Juliana "A Artista" Costa</h4>
                                <p class="text-yellow-600 font-semibold">Especialista em Cor e Design</p>
                                <p class="mt-3 text-gray-600">
                                   Juliana traz a arte para o cabelo. Especialista em coloração e desenhos freestyle, ela transforma seu cabelo em uma tela, criando looks personalizados e cheios de atitude.
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="text-center mt-12 pt-8 border-t border-gray-200">
                         <h3 class="text-2xl font-bold">Pronto para transformar seu estilo?</h3>
                         <a href="{{ route('agendamento.index') }}" class="mt-4 inline-block bg-yellow-500 text-gray-900 font-bold py-3 px-8 rounded-lg hover:bg-yellow-600 transition duration-300">
                            Agende seu Horário
                         </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
