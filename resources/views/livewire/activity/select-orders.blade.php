<div class="col-span-6 sm:col-span-3">
    <div class="flex gap-x-3 items-center">
        <span class="text-sm font-medium text-gray-700">Ordenes </span>
        @if($active)
            <div class="relative flex flex-col items-center group cursor-pointer">
                <svg @click="modalAddOrder = !modalAddOrder" xmlns="http://www.w3.org/2000/svg" class="text-gray-500 h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
                <div class="absolute bottom-0 flex-col items-center hidden mb-5 group-hover:flex w-32 opacity-100">
                    <span class="relative z-10 p-2 text-xs leading-none text-white whitespace-no-wrap bg-gray-400 shadow-lg rounded-md">
                        Agrega orden
                    </span>
                    <div class="w-3 h-3 -mt-2 rotate-45 bg-gray-300"></div>
                </div>
            </div>
        @endif
    </div>
    <div class="flex">
        @forelse($ordersArray as $ord)
            <div class="bg-indigo-100 inline-flex items-center text-sm rounded mt-2 mr-1">
                <input type="hidden" name="order_id[]" value="{{$ord['id']}}">
                <span class="ml-2 mr-1 leading-relaxed truncate max-w-xs text-gray-900">Pedido #{{$ord['reference']}}</span>
                <div class="relative flex flex-col items-center group cursor-pointer">
                    <button type="button" wire:click="removeOrderToActivity({{$ord['id']}})" class="w-6 h-8 inline-block align-middle text-gray-500 hover:text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6 fill-current mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z"/></svg>
                    </button>
                    <div class="absolute bottom-0 flex-col items-center hidden mb-5 group-hover:flex w-32 opacity-100">
                        <span class="relative z-10 p-2 text-xs leading-none text-white whitespace-no-wrap bg-gray-400 shadow-lg rounded-md">
                            Eliminar el Pedido de la Actividad
                        </span>
                        <div class="w-3 h-3 -mt-2 rotate-45 bg-gray-300"></div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>

    <div
        x-on:close.stop="modalAddOrder = false"
        x-on:keydown.escape.window="modalAddOrder = false"
        x-show="modalAddOrder" 
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
                                Agregar pedido a la actividad
                            </h3>
                            <p class="text-sm text-gray-500">
                                Escoje un pedido para añadirlo a tu actividad.
                            </p>
                            <br>
                        </div>
                    </div>
                    <div class="py-2 relative text-gray-600 w-full">
                        <input class="border-2 border-gray-300 bg-white h-10 px-5 rounded-lg w-full text-sm focus:outline-none"
                            type="search" name="search" placeholder="Buscar" wire:model="search">
                        <button type="submit" class="absolute right-0 top-0 mt-5 cursor-pointer">
                            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                            viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                            width="512px" height="512px">
                            
                            </svg>
                        </button>
                    </div>    
                    <div class="scroll-beauty-list overflow-hidden overflow-y-auto w-full h-full pt-3" style="height:290px; max-height:290px;">
                        <span class="p-3 text-center text-sm font-semibold text-gray-700">Pedidos </span>
                        <ul class="w-full {{count($orders)>0 ? '' : 'flex justify-center items-center h-32'}}">
                            @forelse($orders as $order)
                                <a href="javascript:;" @click="modalAddOrder = !modalAddOrder" wire:click="addOrderToActivity({{$order->id}}, {{$order->reference}})">
                                    <li class="overflow-hidden w-full h-14 rounded-md flex justify-between items-center px-3 gap-x-3 hover:bg-gray-200">

                                        <div class="flex gap-x-4 items-center w-full">
                                            <!-- <div class="text-sm mr-4">
                                                <button type="button" >Select</button>
                                            </div> -->
                                            <div class="text-sm font-medium text-gray-900">
                                                Id: {{$order->id}}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Referencia: #{{$order->reference}}
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
                    <button type="button" @click="modalAddOrder = !modalAddOrder" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
