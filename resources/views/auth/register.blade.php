{{--<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />
        <div class="w-full flex justify-center items-center">
            <span class="hidden text-red-700 text-sm" id="text-fail">Lo lamentamos, no se encuentra dentro de nuestros registros de cliente actualmente</span>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="cedula" value="{{ __('Cedula') }}" />
                <x-jet-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('name')" required autofocus />
            </div>
            
            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
            </div>

            <div>
                <x-jet-label for="lastname" value="{{ __('LastName') }}" />
                <x-jet-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required />
            </div>
            
            <div>
                <x-jet-label for="phone" value="{{ __('Telefono') }}" />
                <x-jet-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div>
                <x-jet-label for="address" value="{{ __('Dirección') }}" />
                <x-jet-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>--}}

<x-guest-layout>
    <div class="w-full min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <!-- <img class="mx-auto h-32 w-auto" src="{{asset('assets/images/logo-uae.jpg')}}" alt="Workflow"> -->
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Registrarse
                </h2>
                <!-- <p class="mt-2 text-center text-sm text-gray-600">
                    O
                    <a href="/login" class="font-medium text-indigo-600 hover:text-indigo-500"> Iniciar sesión </a>
                </p> -->
                @if (session('status'))
                    <div class="my-4 font-medium text-sm text-green-600 text-center">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="w-full">
                    <x-toast-message></x-toast-message>
                </div>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST" autocomplete="off">
                @csrf
                
                <div class="rounded-md shadow-sm">
                    <div class="mt-2">
                        <label for="cedula" class="sr-only">Cedula</label>
                        <input id="cedula" name="cedula" type="text" required onkeypress="return onlyNumbers(event)" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Cedula de identidad" value="{{old('cedula')}}" autofocus>
                        <span class="hidden text-red-700 text-sm ml-2">La cedula no es valida.</span>
                    </div>
                    <div class="mt-2">
                        <label for="name" class="sr-only">Nombre</label>
                        <input id="name" name="name" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Nombres" value="{{old('name')}}">
                    </div>
                    <div class="mt-2">
                        <label for="lastname" class="sr-only">Apellidos</label>
                        <input id="lastname" name="lastname" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Apellidos" value="{{old('lastname')}}">
                    </div>
                    <div class="mt-2">
                        <label for="phone" class="sr-only">Telefono</label>
                        <input id="phone" name="phone" type="text" onkeypress="return onlyNumbers(event)" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Telefono" value="{{old('phone')}}">
                    </div>
                    <div class="mt-2">
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Correo electronico" value="{{old('email')}}">
                    </div>
                    <div class="mt-2">
                        <label for="address" class="sr-only">Dirección</label>
                        <input id="address" name="address" type="text" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Nombres" value="{{old('address')}}">
                    </div>
                    <div class="mt-2">
                        <label for="password" class="sr-only">Contraseña</label>
                        <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Contraseña">
                    </div>
                    <div class="mt-2">
                        <label for="password_confirmation" class="sr-only">Confirmar contraseña</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Confirmar Contraseña">
                    </div>
                </div>
                <div class="flex items-center justify-end"> 
                    <div class="text-sm">
                        <a class="font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('login') }}">
                                ¿Ya tienes una cuenta?
                        </a>
                    </div>
                </div>
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Registrarme
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // document.getElementById('cedula').addEventListener('blur', async () => {
        //     const url = 'http://181.39.128.194:8092/SAN32.WS.Rest.Bitacora/api/ValidarIdentificacion/ValidarIdentificacion'
    
        //     var data = {
        //                 cedula: document.getElementById('cedula').value,
        //                 empresa: 'All Padel'
        //             }

        //         fetch(url, {
        //             method: 'POST', 
        //             body: JSON.stringify(data), 
        //         }).then(res => res.json())
        //         .catch(error => console.error('Error:', error))
        //         .then(response => console.log('Success:', response));

        //     // const response = await fetch(url, {
        //     //                             method: 'POST',
        //     //                             mode: 'no-cors', // no-cors, *cors, same-origin
        //     //                             cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        //     //                             headers: {
        //     //                             'Content-Type': 'application/json'
        //     //                             // 'Content-Type': 'application/x-www-form-urlencoded',
        //     //                             },
        //     //                             body:  JSON.stringify({
        //     //                                 cedula: document.getElementById('cedula').value,
        //     //                                 empresa: 'All Padel'
        //     //                             }),
        //     //                         }).then(response => response.json())
        //     //                         .catch(err => alert(`Ha ocurrido un error: ${err}`))
        //     //                         .then(response => {
        //     //                             if(response.CodigoError == "00"){
        //     //                                 const textFail = document.getElementById('text-fail')
                                            
        //     //                                 if(response.Response[0].EXISTE_CLIENTE == 0){
        //     //                                     textFail.classList.remove("hidden")
        //     //                                 }else{
        //     //                                     textFail.classList.add("hidden")
        //     //                                 }

        //     //                             }else{
        //     //                                 alert(`Ha ocurrido un error: ${response.MensajeError}`)
        //     //                             }
        //     //                         })

        // })
    </script>
</x-guest-layout>
