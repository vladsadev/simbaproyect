<x-panel class="items-start">
        <div class="flex-shrink-0 bg-black self-center">
            <img src="{{Vite::asset('resources/images/simba1.webp')}}" alt="SIMBA S7D" class="w-full md:w-64 h-42 object-cover
            rounded-lg shadow-md">
        </div>

        <div class="flex-1 py-3 text-sm text-gray-600">
            <h3 class="mt-2 font-bold text-xl text-gray-900 group-hover:text-yellow-600 transition-colors
            duration-300">Equipo: SIMBA S7D</h3>
            <h4 class="text-lg font-semibold my-2">Características Generales</h4>
            <p class="text-gray-600">Fabricante: <span class="font-semibold text-gray-800">Epiroc</span></p>
            <p class="mt-2 text-gray-600">Tipo de Combustible: <span class="font-semibold text-gray-800">Diesel</span></p>
            <div class="grid grid-cols-2 gap-4 mt-3 text-gray-600">
                <p>Largo: <span class="font-semibold text-gray-800">12.5 metros</span></p>
                <p>Ancho: <span class="font-semibold text-gray-800">12.5 metros</span></p>
                <p>Alto: <span class="font-semibold text-gray-800">12.5 metros</span></p>
                <p>Peso: <span class="font-semibold text-gray-800">45 toneladas</span></p>
            </div>
            <a href="#" class="inline-block mt-4 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors font-semibold text-sm">
                Ficha Técnica→
            </a>
        </div>

{{--    Acciones --}}
        <div class="space-y-2 self-start flex flex-col">
            <div class="flex gap-2">
                <p class="font-bold">Estado:</p>
                <span>Operativa</span>
            </div>
            <h4 class="text-lg font-semibold my-2">Acciones</h4>
            <a href="#" class="inline-block mt-4 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors font-semibold text-sm">
                Agendar Mantenimiento
            </a>
            <a href="#" class="inline-block mt-4 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors font-semibold text-sm">
                Modificar Estado
            </a>
        </div>

</x-panel>
