@if(\Auth::user()->admin == 1)
    <div class="flex mx-auto w-full py-8" x-data="{ isOpen: false, isOpenChangePassword: false }" >
        <div class="w-full px-4">
            <div class="flex justify-between items-center">
                <div class="py-2 relative text-gray-600 w-2/5">
                <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg w-full text-sm focus:outline-none"
                    type="search" name="search" placeholder="Buscar" wire:model="search">
                <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
                    <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                    viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                    width="512px" height="512px">
                    <path
                        d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  
                            s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,
                            2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,
                            23.984,6z" />
                    </svg>
                </button>
                </div>
                <div class="w-2/5 flex justify-end items-center">
                    <a href="{{route('user.create.admin')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium 
                                rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                focus:ring-indigo-500 ">
                        Crear
                    </a>
                <span class="text-gray-700 text-xs mx-4 font-semibold uppercase">
                    Filtrar por
                </span>
                <div class="relative flex items-center text-gray-700 text-sm rounded-md font-semibold bg-gray-300 pl-4 pr-7 py-1">
                    {{ $status === 1 ? 'Activa' : 'Desactivada'}}
                    <div x-data="{ open: false }" class="cursor-pointer absolute top-0 right-0 mt-1 mr-1 z-5">
                        <x-jet-dropdown align="right">
                            <x-slot name="trigger">
                                <div class="w-full flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-slot>

                            <x-slot name="content">
                                <x-jet-dropdown-link href="#" wire:click="filterOne">
                                    Activa
                                </x-jet-dropdown-link>
                                <x-jet-dropdown-link href="#" wire:click="filterTwo">
                                    Desactivada
                                </x-jet-dropdown-link>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                </div>
                </div>
            </div>
            <div class="flex flex-col mt-6">
                <div class="flex items-center gap-x-2">
                <div class="mb-2">
                    <div class="w-12 relative flex items-center text-sm rounded-md font-semibold bg-gray-200 p-2">
                    <input id="checkMain" type="checkbox" class="form-checkbox h-5 w-5 text-teal-600 cursor-pointer rounded-md" wire:click="$emit('checkOrUncheckAll')">
                        <div x-data="{ open: false }" class="cursor-pointer absolute top-0 right-0 mt-1 mr-1 z-5">
                            <x-jet-dropdown align="left">
                                <x-slot name="trigger">
                                    <div class="w-full flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </x-slot>

                                <x-slot name="content">
                                    <x-jet-dropdown-link href="#">
                                    Todas
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link href="#">
                                    Ninguna
                                    </x-jet-dropdown-link>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    </div>
                </div>
                    <div class="{{count($usersSelected) > 0 ? '' : 'hidden'}} relative flex flex-col items-center group">
                        <div class="flex items-center justify-center h-10 w-10 rounded-full hover:bg-gray-200 cursor-pointer text-gray-500 hover:text-gray-800 mb-2" @click="isOpen = !isOpen">  
                            @if($status == 1)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                                </svg>
                            @else              
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                        <div class="absolute bottom-0 flex-col items-center hidden mb-12 group-hover:flex w-32 opacity-100">
                            <span class="relative z-10 p-2 text-xs leading-none text-white whitespace-no-wrap bg-gray-300 shadow-lg rounded-md">
                                {{ $status == 1 ? 'Desactivar' : 'Activar'}} cuenta
                            </span>
                            <div class="w-3 h-3 -mt-2 rotate-45 bg-gray-300"></div>
                        </div>
                    </div>
                    <div class="{{count($usersSelected) > 0 ? '' : 'hidden'}} relative flex flex-col items-center group">
                        <div class="flex items-center justify-center h-10 w-10 rounded-full hover:bg-gray-200 cursor-pointer text-gray-500 hover:text-gray-800 mb-2" @click="isOpenChangePassword = !isOpenChangePassword">  
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="absolute bottom-0 flex-col items-center hidden mb-12 group-hover:flex w-36 opacity-100">
                            <span class="relative z-10 p-2 text-xs leading-none text-white whitespace-no-wrap bg-gray-300 shadow-lg rounded-md">
                                Cambiar contraseñas
                            </span>
                            <div class="w-3 h-3 -mt-2 rotate-45 bg-gray-300"></div>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <x-toast-message></x-toast-message> 
                </div>
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="usersTable bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                    <label class="inline-flex items-center mt-3">
                                        <input id="{{ $user->id }}" type="checkbox" class="form-checkbox h-5 w-5 text-teal-600 cursor-pointer rounded-md" wire:click="addUserInArray({{ $user->id }}, {{ $user->active == 1 ? 0 : 1 }}, '{{ $user->name }}', '{{ $user->email }}', '', '{{$user->profile_photo_path ? $user->profile_photo_path : $user->profile_photo_url}}')">
                                    </label>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{$user->profile_photo_path ? $user->profile_photo_path : $user->profile_photo_url}}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                            {{$user->lastname .' '. $user->name}}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                            {{ $user->email }}
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $user->active === 1 ? 'green' : 'red'}}-100 text-{{ $user->active === 1 ? 'green' : 'red'}}-800">
                                        {{ $user->active === 1 ? 'Activa' : 'Desactivada'}}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <p class="truncate"></p>    
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                <td colspan="6">
                                    <div class="w-full flex justify-center items-center text-base text-gray-400 my-4">No existen datos asociados a su busqueda.</div>
                                </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        </div>
                        <div class="clearfix mt-4">
                        </div>
                        {{$users->links()}}
                    </div>
                </div>
            </div>
            </div>  
            <div
                x-on:close.stop="isOpen = false"
                x-on:keydown.escape.window="isOpen = false"
                x-show="isOpen" 
                x-transition:enter="ease-out duration-300 transform"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed z-10 inset-0 overflow-y-auto"
                style="display: none;">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form action="{{route('user.desactive.account')}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Heroicon name: exclamation -->
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                {{ $status == 1 ? 'Desactivar' : 'Activar'}} Cuenta
                            </h3>
                            <p class="text-sm text-gray-500">
                                ¿Estás seguro de que deseas {{ $status == 1 ? 'desactivar' : 'activar'}} las cuentas seleccionadas? Una vez que {{ $status == 1 ? 'desactive' : 'active'}} la cuenta, se {{ $status == 1 ? 'negara' : 'permitira'}}  el acceso del usuario a la plataforma. Ingrese su contraseña para confirmar que desea {{ $status == 1 ? 'desactivar' : 'activar'}} la cuenta.
                            </p>
                            <br>
                            <div class="scroll-beauty-list overflow-hidden overflow-y-auto py-2" style="max-height:200px;">
                                <ul class="w-full">
                                @forelse($usersSelected as $userSelected)
                                    <li class="shadow overflow-hidden border-b border-gray-200 w-full h-14 rounded-md flex justify-between items-center px-3 gap-x-3 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{$userSelected['photo']}}" alt="{{$userSelected['name']}}">
                                        </div>
                                        <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{$userSelected['name']}}
                                            <input type="hidden" name="id[]" value="{{$userSelected['id']}}">
                                            <input type="hidden" name="active[]" value="{{$userSelected['active']}}">
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{$userSelected['email']}}
                                        </div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500 w-28">
                                        <p class="truncate"></p>
                                    </div>
                                    <div class="text-sm text-gray-300 cursor-pointer" wire:click="removeUserInArray( {{ $userSelected['id'] }} )">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    </li>
                                @empty
                                @endforelse
                                </ul>
                            </div>  
                            <input type="password" name="password" class="border mt-4 w-full py-1 px-4 rounded-md text-sm" placeholder="Contraseña" required>
                            </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="delete-user w-full inline-flex justify-center rounded-md border border-transparent 
                            shadow-sm px-4 py-2 text-base font-medium text-white 
                            {{ $status == 1 ? 'hover:bg-red-700' : 'hover:bg-indigo-700'}}  focus:outline-none focus:ring-2 
                            focus:ring-offset-2 {{ $status == 1 ? 'bg-red-600' : 'bg-indigo-600'}} focus:ring-red-500 sm:ml-3 
                            sm:w-auto sm:text-sm">
                                {{ $status == 1 ? 'Desactivar' : 'Activar'}}
                            </button>
                            <button type="button" @click="isOpen = !isOpen" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>  
            <div
                x-on:close.stop="isOpenChangePassword = false"
                x-on:keydown.escape.window="isOpenChangePassword = false"
                x-show="isOpenChangePassword" 
                x-transition:enter="ease-out duration-300 transform"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed z-10 inset-0 overflow-y-auto"
                style="display: none;">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form action="{{route('user.passwords.update')}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Heroicon name: exclamation -->
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                    Cambiar contraseñas en cuentas seleccionadas
                                </h3>
                                    <p class="text-sm text-gray-500">
                                        ¿Estás seguro de que deseas cambiar la contraseña a las cuentas seleccionadas?. 
                                    </p>
                                    <br>
                                    <div class="scroll-beauty-list overflow-hidden overflow-y-auto py-2" style="max-height:200px;">
                                    <ul class="w-full">
                                        @forelse($usersSelected as $userSelected)
                                        <li class="shadow overflow-hidden border-b border-gray-200 w-full h-14 rounded-md flex justify-between items-center px-3 gap-x-3 hover:bg-gray-50">
                                            <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="{{$userSelected['photo']}}" alt="{{$userSelected['name']}}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                {{$userSelected['name']}}
                                                <input type="hidden" name="id[]" value="{{$userSelected['id']}}">
                                                <input type="hidden" name="active[]" value="{{$userSelected['active']}}">
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                {{$userSelected['email']}}
                                                </div>
                                            </div>
                                            </div>
                                            <div class="text-sm text-gray-500 w-28">
                                            <p class="truncate"></p>  
                                            </div>
                                            <div class="text-sm text-gray-300 cursor-pointer" wire:click="removeUserInArray( {{ $userSelected['id'] }} )">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                            </div>
                                        </li>
                                        @empty
                                        @endforelse
                                    </ul>
                                    </div>
                                <input type="password" name="passwordUsers" class="border mt-4 w-full py-1 px-4 rounded-md text-sm" placeholder="Nueva Contraseña" required>
                            </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="delete-user w-full inline-flex justify-center rounded-md border border-transparent 
                            shadow-sm px-4 py-2 text-base font-medium text-white 
                            {{ $status == 1 ? 'hover:bg-red-700' : 'hover:bg-indigo-700'}}  focus:outline-none focus:ring-2 
                            focus:ring-offset-2 {{ $status == 1 ? 'bg-red-600' : 'bg-indigo-600'}} focus:ring-red-500 sm:ml-3 
                            sm:w-auto sm:text-sm">
                                Guardar
                            </button>
                            <button type="button" @click="isOpenChangePassword = !isOpenChangePassword" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>  
            <script>
                Livewire.on('removeUserInArray', id => {
                    if (document.getElementById(id).checked){
                    document.getElementById(id).checked = false
                    }
                })
                Livewire.on('checkOrUncheckAll', () => {
                let checkboxs = document.querySelectorAll(".usersTable input[type=checkbox]")
                
                checkboxs.forEach((element) => {
                    if(!element.checked && document.getElementById('checkMain').checked){
                        element.click()
                    }else if(element.checked && !document.getElementById('checkMain').checked){
                        element.click()
                    }
                });
                })
            </script>  
    </div>
@else
    <div class="w-full h-screen flex justify-center items-center">
        <span class="text-lg text-gray-500">Lo sentimos, no tienes permisos suficientes para acceder a este recurso</span>
    </div>
@endif

