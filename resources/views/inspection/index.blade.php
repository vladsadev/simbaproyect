<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Inspecciones') }}
            </h2>
        </div>
    </x-slot>

    <x-panels.main>

{{--        @livewire('users-table');--}}
        @livewire('inspection-table');


    </x-panels.main>
</x-app-layout>
