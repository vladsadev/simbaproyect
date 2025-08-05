@props(['machine'])

<div class="bg-white rounded-xl shadow-md border border-yellow-300 overflow-hidden hover:shadow-lg transition">
    <!-- Imagen -->
    <div class="relative">
        <img src="{{Vite::asset('resources/images/simba1.webp')}}" alt="SIMBA S7D" class="w-full h-40 object-cover">
        <span
            class="absolute top-2 left-2 bg-green-200 text-green-700 text-xs font-semibold px-3 py-1 rounded-full shadow">
                        Operativa
                    </span>
    </div>

    <!-- Contenido -->
    <div class="px-4 pt-2 pb-3">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900 mb-1">
                {{$machine->equipmentType->name}} <span class="text-yellow-500 font-semibold">{{$machine->model}}</span>
            </h2>
            <p class="text-sm font-semibold text-blue-light">{{$machine->brand}}</p>
        </div>

        {{--        <h4 class="text-sm mb-2 font-semibold">Resumen</h4>--}}
        <!-- Datos en 1 columna -->
        <hr class="mb-1.5">
        <div class="grid grid-cols-1 gap-x-4 gap-y-1 text-xs text-gray-600 mb-3">
            <x-machine.field name="Último Mantenimiento">{{$machine->last_maintenance}} </x-machine.field>
            <x-machine.field name="Próximo Mantenimiento">{{$machine->last_maintenance}} </x-machine.field>
        </div>

        <!-- Datos en 1 columna -->
        <div class="grid grid-cols-1 gap-x-4 gap-y-1 text-xs text-gray-600 mb-3">
            <x-machine.field name="Horas Trabajadas"> 248</x-machine.field>
        </div>

        <!-- Botone(s) de acción-->
        <div class="flex justify-end pt-2 flex-wrap gap-2">
            <x-link-btn href="{{route('equipment.show',$machine['id'])}}"
                        class="bg-yellow-400 cursor-pointer hover:bg-yellow-500 text-white text-xs font-semibold py-1.5 px-3 rounded-lg
                shadow
                transition">
                Ver Equipo
            </x-link-btn>
        </div>
    </div>
</div>

