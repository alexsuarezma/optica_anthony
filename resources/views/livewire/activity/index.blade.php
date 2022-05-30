<div class="relative overflow-x-auto shadow-md sm:rounded-lg" x-data="{ modalSalesman: false }">
        <div class="max-w-7xl mx-auto sm:px1-">
            <div class="bg-white overflow-hidden">
                <div class="flex justify-center mx-auto w-full pt-2 pb-2 gap-x-2">
                    <div class="overflow-hidden sm:rounded-md w-full">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="pt-6 grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="aperture_date" class="block text-sm font-medium text-gray-700">Fecha Apertura</label>
                                    <input type="date" wire:model="fecha_inicio" id="aperture_date"  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="departure_date" class="block text-sm font-medium text-gray-700">Fecha Cierre</label>
                                    <input type="date" wire:model="fecha_fin" id="departure_date"  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-1"></div>
                                <div class="col-span-1">
                                    @if(\Auth::user()->admin == 1)
                                        <label for="salesman_id" class="block text-sm font-medium text-gray-700">Vendedor</label>
                                        <div class="flex gap-x-1">
                                            <div class="relative text-gray-600 w-full">
                                                <input class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    type="text" id="salesman_id" wire:model="salesman_id">
                                                <button @click="modalSalesman = true" type="submit" class="absolute right-0 top-0 mt-3 cursor-pointer pr-2">
                                                    <svg class="text-gray-600 h-6 w-6 fill-current" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 
                                                            1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>   
                                            <div class="text-gray-600 w-full">
                                                <input readonly type="text" wire:model="salesman_description" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="detail_activity_id" class="block text-sm font-medium text-gray-700">Detalle de actividades</label>
                                    <select id="detail_activity_id" wire:model="detail_activity_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm 
                                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                        <option value="0">Todos</option>
                                        @forelse($detail_activities as $activity)
                                            <option value="{{$activity->id}}">{{$activity->description}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="state_activity" class="block text-sm font-medium text-gray-700">Estado</label>
                                    <select id="state_activity" wire:model="state_activity" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm 
                                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                        <option value="T">Todos</option>
                                        <option value="A">Activos</option>
                                        <option value="F">Finalizado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <div class="flex items-center justify-between px-4">
        <div class="p-4">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative mt-1">
                <input wire:model="search" type="text" id="table-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
        @if(\Auth::user()->salesman == 1)
            <a href="{{route('activity.create')}}" class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                Crear
            </a>
        @endif
    </div>
    <div class="w-full px-4">
        <x-toast-message></x-toast-message>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="p-4">
                <div class="flex items-center">
                    <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    N. Actividad
                </th>
                <th scope="col" class="px-6 py-3">
                    Pedidos
                </th>
                <th scope="col" class="px-6 py-3">
                    Vendedor
                </th>
                <th scope="col" class="px-6 py-3">
                    Estado
                </th>
                <th scope="col" class="px-6 py-3">
                    Actividad
                </th>
                <th scope="col" class="px-6 py-3">
                    F. Aper.
                </th>
                <th scope="col" class="px-6 py-3">
                    F. Fin.
                </th>
                <th scope="col" class="px-6 py-3">
                    F. Entr.
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Editar</span>
                    <span class="sr-only">Cerrar</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $activity)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                    </div>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{$activity->id}}
                    </th>
                    <td class="px-6 py-4">
                        @forelse($activity->orders as $order)
                            {{ $loop->first ? '' : ', ' }} #{{$order->order->reference}}
                        @empty
                            No hay ordenes en la Actividad.
                        @endforelse
                    </td>
                    <td class="px-6 py-4">
                        {{$activity->user->name.' '.$activity->user->lastname}}
                    </td>
                    <td class="px-6 py-4">
                        {{$activity->departure_date == null ? 'Activo' : 'Finalizado'}}
                    </td>
                    <td class="px-6 py-4">
                        {{$activity->detailActivity->description}}
                    </td>
                    <td class="px-6 py-4">
                        {{$activity->aperture_date}}
                    </td>
                    <td class="px-6 py-4">
                        {{$activity->departure_date == null ? 'S/F' : $activity->departure_date}}
                    </td>
                    <td class="px-6 py-4">
                        {{$activity->delivery_date == null ? 'S/F' : $activity->delivery_date}}
                    </td>
                    <td class="px-6 py-4 flex items-center justify-end gap-x-4">
                        <a href="{{route('activity.update', ['id' => $activity->id ] )}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            @if(\Auth::user()->id == $activity->user_id)
                                {{$activity->departure_date == null ? 'Editar' : 'Ver Info.' }}
                            @else
                                Ver Info
                            @endif
                        </a>
                        @if($activity->departure_date == null && \Auth::user()->id == $activity->user_id)
                            <form action="{{route('activity.deaperture.update.put')}}" method="post">
                                @csrf 
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$activity->id}}">
                                <button class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Finalizar</a>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <span class="text-center">No hay datos asociados a su busqueda</span>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="clearfix mt-4"></div>
    {{$activities->links()}}

    <div
        x-on:close.stop="modalSalesman = false"
        x-on:keydown.escape.window="modalSalesman = false"
        x-show="modalSalesman" 
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
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <!-- Heroicon name: exclamation -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                Selecciona un registro
                            </h3>
                            <p class="text-sm text-gray-500">
                                Escoje un vendedor.
                            </p>
                            <br>
                        </div>
                    </div>
                    <div class="py-2 relative text-gray-600 w-full">
                        <input class="border-2 border-gray-300 bg-white h-10 px-5 rounded-lg w-full text-sm focus:outline-none"
                            type="searchSalesman" name="searchSalesman" placeholder="Buscar" wire:model="searchSalesman">
                        <button type="submit" class="absolute right-0 top-0 mt-5 cursor-pointer">
                            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                                viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                                width="512px" height="512px">
                            </svg>
                        </button>
                    </div>    
                    <div class="scroll-beauty-list overflow-hidden overflow-y-auto w-full h-full pt-3" style="height:290px; max-height:290px;">
                        <span class="p-3 text-center text-sm font-semibold text-gray-700">Usuarios </span>
                        <ul class="w-full {{count($users)>0 ? '' : 'flex justify-center items-center h-32'}}">
                            @forelse($users as $user)
                                <a href="javascript:;" @click="modalSalesman = !modalSalesman" wire:click="selectSalesman({{$user}})">
                                    <li class="overflow-hidden w-full h-14 rounded-md flex justify-between items-center px-3 gap-x-3 hover:bg-gray-200">
                                        <div class="flex gap-x-4 items-center w-full">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{$user->id}}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{$user->name}}
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @empty
                                <span class="text-gray-400 text-sm">No existen coincidencias asociadas a su busqueda.</span>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="modalSalesman = !modalSalesman" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>