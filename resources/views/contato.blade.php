@extends('layouts.app')

@section('content')
    <div class="bg-gray-900 flex items-center justify-center my-8 overflow-hidden">
        <div class="w-full max-w-lg mx-4">
            <!-- Logo -->
            <div class="flex justify-center mb-10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 w-auto">
            </div>

            <div class="bg-gray-800 p-10 rounded-xl shadow-lg text-gray-300">
                <h2 class="text-3xl font-extrabold text-yellow-500 text-center mb-8">Fale Conosco</h2>

                <p class="mb-8 text-center text-gray-400 text-sm leading-relaxed">
                    Tem alguma dúvida? Preencha os dados abaixo para entrar em contato conosco via WhatsApp.
                </p>

                <form id="contactForm" class="space-y-6">
                    <!-- Assunto -->
                    <div>
                        <label for="subject" class="block text-sm font-semibold mb-2">Assunto</label>
                        <select id="subject" name="subject" required
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-md text-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                            <option value="" disabled selected>Selecione um assunto</option>
                            <option value="Dúvida sobre serviços">Dúvida sobre serviços</option>
                            <option value="Horários de atendimento">Horários de atendimento</option>
                            <option value="Preços e promoções">Preços e promoções</option>
                            <option value="Outros assuntos">Outros assuntos</option>
                        </select>
                    </div>

                    <!-- Mensagem -->
                    <div>
                        <label for="message" class="block text-sm font-semibold mb-2">Sua Mensagem</label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-md text-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition resize-none"></textarea>
                    </div>

                    <div class="flex justify-center">
                        <button type="button" onclick="generateWhatsAppLink()"
                            class="inline-flex items-center px-8 py-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.479 5.093 1.479 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Enviar Mensagem
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script com o nome do usuário autenticado --}}
    <script>
        @auth
        const userName = @json(Auth::user()->name);

        function generateWhatsAppLink() {
            const phoneNumber = '5511955504793'; // número do barbeiro
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();

            if (!subject || !message) {
                alert("Por favor, preencha todos os campos antes de enviar.");
                return;
            }

            let whatsappMessage = `Olá, tenho uma dúvida!\n\n`;
            whatsappMessage += `*Nome:* ${userName}\n`;
            whatsappMessage += `*Assunto:* ${subject}\n\n`;
            whatsappMessage += `*Mensagem:* ${message}\n`;

            const encodedMessage = encodeURIComponent(whatsappMessage);

            const isMobile = /iPhone|Android/i.test(navigator.userAgent);
            const baseUrl = isMobile ? 'https://wa.me/' : 'https://web.whatsapp.com/send';
            const whatsappUrl = `${baseUrl}?phone=${phoneNumber}&text=${encodedMessage}`;

            window.open(whatsappUrl, '_blank');
        }
        @endauth
    </script>
@endsection
