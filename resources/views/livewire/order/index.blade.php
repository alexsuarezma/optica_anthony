<div class="relative overflow-x-auto shadow-md sm:rounded-lg" x-data="{ modalInfoOrder: false }">
        <div class="max-w-7xl mx-auto sm:px1-">
            <div class="bg-white overflow-hidden">
                <div class="flex justify-center mx-auto w-full pt-2 pb-2 gap-x-2">
                    <div class="overflow-hidden sm:rounded-md w-full">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="pt-6 grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="aperture_date" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                                    <input type="date" wire:model="fecha_inicio" id="aperture_date"  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="departure_date" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                                    <input type="date" wire:model="fecha_fin" id="departure_date"  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-1"></div>
                                <div class="col-span-1"></div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="detail_activity_id" class="block text-sm font-medium text-gray-700">Detalle de actividades</label>
                                    <select id="detail_activity_id" wire:model="detail_activity_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm 
                                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                        <option value="0">Todos</option>
                                        @forelse($detail_activities as $activity)
                                            <option value="{{$activity->state_id}}">{{$activity->description}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="state_order" class="block text-sm font-medium text-gray-700">Estado</label>
                                    <select id="state_order" wire:model="state_order" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm 
                                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                        <option value="T">Todos</option>
                                        <option value="C">Cerrados</option>
                                        <option value="P">En Proceso</option>
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
                    N. Interno Ord.
                </th>
                <th scope="col" class="px-6 py-3">
                    Referencia Ord.
                </th>
                <th scope="col" class="px-6 py-3">
                    Actividades
                </th>
                <th scope="col" class="px-6 py-3">
                    Cliente
                </th>
                <th scope="col" class="px-6 py-3">
                    Estado
                </th>
                <th scope="col" class="px-6 py-3">
                    F. Ing.
                </th>
                <th scope="col" class="px-6 py-3">
                    F. Ult. Act.
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Info</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                    </div>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{$order->id}}
                    </th>
                    <td class="px-6 py-4">
                        {{$order->reference}}
                    </td>
                    <td class="px-6 py-4">
                        @forelse($order->activities as $activ)
                            {{ $loop->first ? '' : ', ' }}<a href="{{route('activity.update', ['id' => $activ->activity->id ] )}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">#{{$activ->activity->id}}</a>
                        @empty
                            No hay actividades en la Orden.
                        @endforelse
                    </td>                    
                    <td class="px-6 py-4">
                        {{$order->client_id}}
                    </td>
                    <td class="px-6 py-4">
                        {{ $order->state_id !== null ? $order->state->description : '' }}
                    </td>
                    <td class="px-6 py-4">
                        {{$order->created_at}}
                    </td>
                    <td class="px-6 py-4">
                        {{$order->update_at}}
                    </td>
                    <td class="px-6 py-4 flex items-center justify-end gap-x-4">
                        <a @click="modalInfoOrder = true"  href="javascript:;" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Ver Info
                        </a>
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
    {{$orders->links()}}


    <div
        x-on:close.stop="modalInfoOrder = false"
        x-on:close-modal.window="modalInfoOrder = false"
        x-on:keydown.escape.window="modalInfoOrder = false"
        x-show="modalInfoOrder" 
        x-transition:enter="ease-out duration-300 transform"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed z-10 inset-0 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex items-center justify-center min-h-screen pt-4 pb-20 text-center">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="modalInfoOrder = !modalInfoOrder">
                <div class="absolute inset-0 bg-gray-900 opacity-90"></div>
            </div>
            <span class="hidden h-screen" aria-hidden="true">&#8203;</span>
            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-4xl w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                Orden de pedido #
                            </h3>
                            <p class="text-sm text-gray-500">
                                Información del pedido
                            </p>
                        </div>
                    </div>
                    <div class="col-span-6 px-5 my-5">
                        <p class="text-sm text-gray-500">
                            descripcion
                        </p>
                    </div>
                    <div class="col-span-6 px-2">
                        <label for="descripcion_cierre" class="block text-sm font-medium text-gray-700">Descripción del cierre</label>
                        <textarea name="descripcion_cierre" id="descripcion_cierre" rows="2" class="mt-1 
                            focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="modalInfoOrder = false" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 
                            shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none 
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Ok
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>