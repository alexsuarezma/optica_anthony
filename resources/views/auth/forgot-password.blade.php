<x-guest-layout>
    <div class="w-full min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <!-- <img class="mx-auto h-32 w-auto" src="{{asset('assets/images/logo-uae.jpg')}}" alt="Workflow"> -->
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Inicia sesión con tu cuenta
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                        All Padel
                    </a>
                </p>
                @if (session('status'))
                    <div class="my-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                <x-jet-validation-errors class="my-4" />
            </div>
            <form class="mt-8 space-y-6"  action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-4 text-sm text-gray-600">
                {{ __('¿Olvidaste tu contraseña? No hay problema. Simplemente díganos su dirección de correo electrónico y le enviaremos un enlace para restablecer la contraseña que le permitirá elegir una nueva.') }}
            </div>

                
                <input type="hidden" name="remember" value="true">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email-address" class="sr-only">Correo electronico</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Correo electronico" :value="old('email')" autofocus>
                    </div>
                </div>
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Restablecer contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
