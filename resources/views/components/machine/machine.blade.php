<!-- Imagen principal -->
<div class="relative">
    <img src="{{Vite::asset('resources/images/simba1.webp')}}" alt="SIMBA S7D" class="w-full h-72 object-cover">
    <span class="absolute top-4 left-4 bg-green-100 text-green-800 text-sm font-semibold px-4 py-1 rounded-full shadow">
      Operativa
    </span>
    <div class="absolute top-4 right-4 flex gap-2">
        <button class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-bold py-2 px-4 rounded-lg shadow transition">
            Agendar Mantenimiento
        </button>
        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold py-2 px-4 rounded-lg shadow transition">
            Volver
        </button>
    </div>
</div>

<!-- Contenido -->
<div class="p-6 space-y-8">

    <!-- Encabezado -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Excavadora <span class="text-yellow-500">S7D</span></h1>
        <p class="text-gray-600 mt-1 text-sm">Código: EQ-00123 • Marca: Caterpillar • Modelo: S7D • Año: 2022</p>
        <p class="text-gray-500 text-xs mt-1">Ubicación: Mina Central</p>
    </div>

    <!-- Ficha técnica -->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Ficha Técnica</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm text-gray-700">
            <p><span class="font-medium">Largo:</span> 12.50 m</p>
            <p><span class="font-medium">Ancho:</span> 12.50 m</p>
            <p><span class="font-medium">Alto:</span> 12.50 m</p>
            <p><span class="font-medium">Peso:</span> 45 t</p>
            <p><span class="font-medium">Potencia:</span> 1200 HP</p>
            <p><span class="font-medium">Combustible:</span> Diesel</p>
            <p><span class="font-medium">Capacidad Combustible:</span> 595 L</p>
            <p><span class="font-medium">Capacidad Cuchara:</span> 8 m³</p>
            <p><span class="font-medium">Carga Máxima:</span> 45 t</p>
            <p><span class="font-medium">Horas Trabajadas:</span> 2500 h</p>
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
            <span class="font-medium">Notas:</span> Equipo en condiciones óptimas. Se recomienda revisión del sistema hidráulico
            antes del próximo turno.
        </p>
    </div>
    <!-- Manuales-->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Manuales</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
            <p><span class="font-medium">Último Mantenimiento:</span> 2025-04-26</p>
            <p><span class="font-medium">Próximo Mantenimiento:</span> 2025-07-07</p>
        </div>
        <p class="mt-3 text-gray-600 text-sm">
            <span class="font-medium">Notas:</span> Equipo en condiciones óptimas. Se recomienda revisión del sistema hidráulico
            antes del próximo turno.
        </p>
    </div>

</div>
