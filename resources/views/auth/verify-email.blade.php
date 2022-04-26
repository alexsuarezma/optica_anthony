<x-guest-layout>
    <div class="w-full min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <img class="mx-auto h-32 w-auto" src="{{asset('assets/images/logo-uae.jpg')}}" alt="Workflow">
                <p class="my-3 text-center text-sm text-gray-600">
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Universidad Agraria del Ecuador
                    </a>
                </p>
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Gracias por registrarte! Antes de comenzar, ¿podría verificar su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar? Si no recibió el correo electrónico, con gusto le enviaremos otro.') }}
                </div>
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionó durante el registro.') }}
                    </div>
                @endif
            </div>
            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" id="send-email" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <div id="loading" class="hidden loader ease-linear rounded-full border-2 border-t-2 border-gray-200 h-5 w-5 mr-3"></div>
                        {{ __('Reenviar correo electrónico de verificación') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                        {{ __('Cerrar sesión') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('send-email').addEventListener('click', ()=> {
            // document.getElementById('send-email').disabled = true
            document.getElementById('loading').classList.remove("hidden");
        })
    </script>
</x-guest-layout>
