@props(['equipment'])

<!-- Imagen principal -->
<div class="relative">
    <img src="{{Vite::asset('resources/images/simba1.webp')}}" alt="SIMBA S7D" class="w-full h-72 object-cover">
    <span class="absolute top-4 left-4 bg-green-300 text-blue-main text-sm md:text-base font-semibold px-4 py-1 rounded-full
    shadow">
      Operativa
    </span>
</div>

<!-- Contenido -->
<div class="p-6 space-y-8">

    <!-- Encabezado -->
    <div class="flex justify-between">
        <div>
{{--            <h1 class="text-3xl font-bold text-gray-900">{{$equipment->equipmentType->name}} <span--}}
{{--                    class="text-yellow-main"> {{$equipment->model}}</span></h1>--}}
            <h3 class="text-2xl font-bold">
                Código: {{$equipment->code}}
            </h3>
            <p class="text-gray-600 mt-1 text-sm lg:text-base"> Marca: {{$equipment->brand}} •
                Modelo:
                {{$equipment->model}} •
                Año:
                {{$equipment->year}}
            </p>
            <p class="text-gray-500 text-xs mt-1">Ubicación: {{$equipment->location}}</p>
        </div>
        <!--Botones de Acciones -->
        <div class="flex flex-col gap-2 justify-start items-end text-center">
            <x-link-btn variant="db" href="{{route('equipment.edit',$equipment)}}" class="text-center">Editar</x-link-btn>
            <x-link-btn>Agendar Mantenimiento</x-link-btn>
        </div>
    </div>

    <!-- Ficha técnica -->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Ficha Técnica</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm text-gray-700">
            <p><span class="font-medium">Largo:</span> {{$equipment->length}} m</p>
            <p><span class="font-medium">Ancho:</span> {{$equipment->width}} m</p>
            <p><span class="font-medium">Alto:</span>{{$equipment->height}} m</p>
            <p><span class="font-medium">Peso:</span>{{$equipment->weight}} </p>
            <p><span class="font-medium">Potencia:</span>{{$equipment->engine_power}} HP</p>
            <p><span class="font-medium">Combustible:</span>{{$equipment->fuel}} </p>
            <p><span class="font-medium">Capacidad Combustible:</span>{{$equipment->fuel_capacity}} L</p>
            <p><span class="font-medium">Capacidad Cuchara:</span>{{$equipment->bucket_capacity}} m³</p>
            <p><span class="font-medium">Carga Máxima:</span>{{$equipment->max_load}} t</p>
            <p><span class="font-medium">Total Horas Trabajadas:</span> 5840 h</p>
            <p><span class="font-medium">Del último mantenimiento:</span> 240 h</p>
        </div>
    </div>

    <!-- Mantenimiento -->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Mantenimiento</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
            <p><span class="font-medium">Último Mantenimiento:</span> 2025-04-26</p>
            <p><span class="font-medium">Próximo Mantenimiento:</span> 2025-07-07</p>
        </div>
        <p class="mt-3 text-gray-600 text-sm">
            <span class="font-medium">Notas:</span> Equipo en condiciones óptimas. En el próximo mantenimiento se recomienda
            revisión del sistema hidráulico y cambiar las mangueras de presión de ...

        </p>
    </div>

    <!-- Manuales-->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Manuales</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
            <p><span class="font-medium">:</span> 2025-04-26</p>
        </div>
    </div>

</div>
