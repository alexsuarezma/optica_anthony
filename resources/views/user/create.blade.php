<x-app-layout>
    <div class="w-full px-20 mt-8">
        @if(\Auth::user()->admin == 0)
            <div class="w-full h-screen flex justify-center items-center">
                <span class="text-lg text-gray-500">Lo sentimos, no tienes permisos suficientes para acceder a este recurso</span>
            </div>
        @else
        <form action="{{route('user.create.admin.post')}}" method="post" autocomplete="off">
            @csrf                                                                
            <div class="flex justify-center mx-auto w-full pt-2 pb-2 gap-x-2">
                    <div class="w-3/5">
                        <div class="w-full">
                            <x-toast-message></x-toast-message>
                        </div>
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-3 bg-white text-right sm:px-6">
                                <button type="submit" class="mt-4 inline-flex justify-center py-2 w-24 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Crear
                                </button>
                            </div>
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <span class="text-lg text-gray-800 font-semibold">Datos</span>
                                <div class="pt-6 grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="cedula" class="block text-sm font-medium text-gray-700">Cedula</label>
                                        <input type="text" name="cedula" id="cedula" required onkeypress="return onlyNumbers(event)" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            value="{{ old('cedula') }}"
                                        >
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Nombres</label>
                                        <input type="text" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            value="{{ old('name') }}"
                                        >
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="lastname" class="block text-sm font-medium text-gray-700">Apellidos</label>
                                        <input type="text" name="lastname" id="lastname"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            value="{{ old('lastname') }}"
                                        >
                                    </div>
                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electronico</label>
                                        <div class="relative">
                                            <input type="text" name="email" id="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            value="{{ old('email') }}"
                                            >
                                        </div>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-2 lg:col-span-2">
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Telefono/Celular</label>
                                        <input type="text" name="phone" id="phone" onkeypress="return onlyNumbers(event)" maxlength="10" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            value="{{ old('phone') }}"
                                        >
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                                        <input type="text" name="address" id="address"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            value="{{ old('address') }}"
                                        >
                                    </div>
                                    <div class="col-span-6 sm:col-span-3 flex justify-end items-center">
                                        <div class="flex items-center">
                                            <input id="admin" name="admin" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="admin" class="ml-2 block text-sm text-gray-900">
                                                Usuario Administrador
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
            </form>
        @endif

        <script>
            document.getElementById('phone').addEventListener('change', () => {
                const input = document.getElementById('phone')
                const resolve = validarTelefono(input)
                const classOk = ['focus:ring-indigo-500','focus:border-indigo-500']
                const classBad = ['border-red-600','focus:ring-red-500' ,'focus:border-red-500']
                if(!resolve){
                    input.value = ''
                    classOk.forEach((cls) => input.classList.remove(cls))
                    classBad.forEach((cls) => input.classList.add(cls))
                }else{
                    classBad.forEach((cls) => input.classList.remove(cls))
                    classOk.forEach((cls) => input.classList.add(cls))
                }
            })
        </script>
    </div>
</x-app-layout>