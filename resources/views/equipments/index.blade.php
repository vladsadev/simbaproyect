<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catálogo de equipos') }}
        </h2>
    </x-slot>

    <x-panels.main>

        {{--        <x-job-card-wide/>--}}
        <x-card-machine/>

    </x-panels.main>

</x-app-layout>
