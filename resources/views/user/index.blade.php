<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>
    
    <div class="w-full px-10">
        <livewire:user.user-list/>    
    </div>
</x-app-layout>