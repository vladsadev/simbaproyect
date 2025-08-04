<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Catálogo de equipos') }}
            </h2>

            <x-link-btn href="{{route('equipment.create')}}">
                Agregar Equipo
            </x-link-btn>
        </div>
    </x-slot>


    <x-panels.main>

        {{--        <x-job-card-wide/>--}}
        <x-card-machine/>

        <ul>

            @foreach($eqs as $e)
                <li>{{$e->equipmentType->name}}, brand: {{$e->brand}}</li>
            @endforeach

        </ul>

        <div>
            {{$eqs->links()}}
        </div>

    </x-panels.main>

</x-app-layout>
