<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(($activity->departure_date !== null ? 'Información de' : 'Actualizar').' Actividad #'.$activity->id) }}
        </h2>
    </x-slot>
    <div class="py-12" x-data="{ modalAddOrder: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="w-full px-4">
                    <x-toast-message></x-toast-message>
                </div>
                <form action="{{route('activity.update.put')}}" method="post" autocomplete="off">
                    @csrf 
                    @method('PUT') 
                    <input type="hidden" name="id" value="{{$activity->id}}">   
                    <div class="flex justify-center mx-auto w-full pt-2 pb-2 gap-x-2">
                        <div class="overflow-hidden sm:rounded-md w-full">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="pt-6 grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Datos de la actividad </label>
                                        <div class="flex py-2">
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                            <span class="mt-2 ml-5 block w-full shadow-sm sm:text-sm font-bold">{{ucwords(\Auth::user()->name)}}</span>
                                        </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="detail_activity_id" class="block text-sm font-medium text-gray-700">Detalle de actividades</label>
                                        <select id="detail_activity_id" name="detail_activity_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm 
                                                                focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                            <option selected disabled>Selecciona...</option>
                                            @forelse($detail_activities as $detailActivity)
                                                <option value="{{$detailActivity->id}}" {{ $detailActivity->id == $activity->detail_activity_id ? 'Selected' : '' }}>{{$detailActivity->description}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @php 
                                        $active = true;
                                    @endphp
                                    @if($activity->departure_date !== null)
                                        @php 
                                            $active = false;
                                        @endphp
                                    @endif
                                    <livewire:activity.select-orders :ordersArray="$ordersArray" :active="$active"/>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="aperture_date" class="block text-sm font-medium text-gray-700">Fecha Apertura</label>
                                        <input type="datetime-local" name="aperture_date" id="aperture_date"  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ date('Y-m-d\TH:i', strtotime($activity->aperture_date)) }}" required>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="departure_date" class="block text-sm font-medium text-gray-700">Fecha Cierre</label>
                                        <input type="datetime-local" name="departure_date" id="departure_date"  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $activity->departure_date !== null ? date('Y-m-d\TH:i', strtotime($activity->departure_date)) : '' }}">
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="delivery_date" class="block text-sm font-medium text-gray-700">Fecha de Entrega</label>
                                        <input type="datetime-local" name="delivery_date" id="delivery_date"  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ date('Y-m-d\TH:i', strtotime($activity->delivery_date)) }}" required>
                                    </div>
                                    <div class="col-span-6">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                        <textarea name="description" id="description" rows="5" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ $activity->description }}</textarea>
                                    </div>
                                </div>
                            @if($activity->departure_date == null && \Auth::user()->id == $activity->user_id)
                                <div class="px-4 py-3 mt-8 bg-white border-t border-gray-200 text-right sm:px-6">
                                    <a href="{{route('dashboard')}}" class="underline mr-4">Cancelar</a>
                                    <button type="submit" class="inline-flex justify-center py-2 px-10 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Guardar actividad
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
