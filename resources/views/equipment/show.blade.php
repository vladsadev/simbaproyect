<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl">
                Código del Equipo:
                <span class="text-yellow-main">{{ $equipment->code}} </span>
            </h2>


            <x-link-btn href="{{route('equipment.index')}}">Volver</x-link-btn>

        </div>
    </x-slot>


    <x-panels.main>

        <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">

            <x-machine.machine :$equipment/>

        </div>

    </x-panels.main>

</x-app-layout>
