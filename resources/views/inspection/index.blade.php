<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Inspecciones') }}
            </h2>
            <div class="flex items-center space-x-4">
                <select class="rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                    <option>SIMBA-SZD-001</option>
                    <option>CAT-320D-002</option>
                    <option>KOM-930E-003</option>
                    <option>VOL-A40G-004</option>
                </select>
                <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                    Cambiar Equipo
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header del Equipo -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
                    <div class="flex justify-between items-center text-white">
                        <div class="space-y-4">
                            <div class="flex gap-4 items-center">
                                <p class="text-sm text-yellow-100">Nombre del Operador del Equipo:</p>
                                <select class="rounded-md border-gray-300 shadow-sm text-gray-700 focus:border-yellow-500
                                focus:ring-yellow-500">
                                    <option>SIMBA-SZD-001</option>
                                    <option>CAT-320D-002</option>
                                    <option>KOM-930E-003</option>
                                    <option>VOL-A40G-004</option>
                                </select>
                            </div>
{{--                            <h3 class="text-lg font-semibold">Equipo                                 SIMBA-SZD-001</h3>--}}
{{--                            <p class="text-yellow-100">Perforadora - Serie: EPI-2024-001</p>--}}
                            <div class="flex gap-4 items-center">
                                <p class="text-sm text-yellow-100">Ubicación:</p>
                                 <x-input class="w-full" placeholder="zona este, parte izquierda cord.."/>
                            </div>
                            <div class="flex gap-4 items-center">
                                <p class="text-sm text-yellow-100">Nombre del Operador del Equipo:</p>
                                <select class="rounded-md border-gray-300 shadow-sm text-gray-700 focus:border-yellow-500
                                focus:ring-yellow-500">
                                    <option>Luis Perez</option>
                                    <option>Marco Torrez</option>
                                    <option>Pedro Alvarez</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-right self-start">
                            <p class="text-sm lg:text-base text-yellow-100 mt-1">Última inspección: Hace 2 horas</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Formulario Principal de Inspección -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Lista de Inspección General</h3>
                                <span class="text-sm text-gray-500">Fecha: {{ date('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        <form class="p-6 space-y-4" id="inspectionForm">
                            @csrf
                            <!-- Items de Inspección -->
                            <div class="space-y-3">
                                @php
                                    $inspectionItems = [
                                        'cuchara' => 'Revisar el estado de la cuchara',
                                        'llantas' => 'Revisar el estado de las llantas',
                                        'articulacion' => 'Revisar engrase en la articulación central superior e inferior',
                                        'cilindro' => 'Revisar engrase en cilindro de dirección',
                                        'botellones' => 'Revisar engrase en los botellones de levante y volteo',
                                        'zbar' => 'Revisar engrase en Z-BAR',
                                        'dogbone' => 'Revisar engrase en DOG-BONE',
                                        'brazo' => 'Revisar engrase en el brazo/puño de cuchara',
                                        'tablero' => 'Verificar estado del tablero del control y display',
                                        'extintores' => 'Revisar extintores y verificar que esté cargado'
                                    ];
                                @endphp

                                @foreach($inspectionItems as $key => $item)
                                    <div class="inspection-item flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-yellow-300 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <input type="checkbox"
                                                   id="{{ $key }}"
                                                   name="items[{{ $key }}]"
                                                   class="inspection-check w-5 h-5 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500"
                                                   data-item="{{ $item }}">
                                            <label for="{{ $key }}" class="text-gray-700 font-medium">{{ $item }}</label>
                                        </div>
                                        <button type="button"
                                                class="issue-btn text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition-colors hidden"
                                                data-target="{{ $key }}"
                                                data-item="{{ $item }}">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Observaciones Generales -->
                            <div class="mt-6">
                                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">Observaciones Generales</label>
                                <textarea id="observaciones"
                                          name="observaciones"
                                          rows="3"
                                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500"
                                          placeholder="Ingrese observaciones adicionales sobre la inspección..."></textarea>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                    <span>Progreso:</span>
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        <div class="progress-bar bg-yellow-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                    <span class="progress-text">0/10</span>
                                </div>
                                <div class="flex space-x-3">
                                    <button type="button" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                                        Omitir
                                    </button>
                                    <button type="submit" class="px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md font-medium transition-colors">
                                        Confirmar Inspección
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Panel Lateral -->
                <div class="space-y-6">
                    <!-- Panel de Seguridad -->
                    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                        <div class="bg-blue-600 px-4 py-3">
                            <h3 class="text-white font-semibold">Equipo de Protección</h3>
                        </div>
                        <div class="p-4">
                            <div class="text-center">
                                <div class="w-24 h-24 mx-auto mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2L3 7l9 5 9-5-9-5zM3 17l9 5 9-5M3 12l9 5 9-5"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-800 mb-2">USO OBLIGATORIO</p>
                                <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-blue-600 rounded-full mr-1"></div>
                                        Casco
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-blue-600 rounded-full mr-1"></div>
                                        Chaleco
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-blue-600 rounded-full mr-1"></div>
                                        Botas
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-blue-600 rounded-full mr-1"></div>
                                        Guantes
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel de Mantenimiento -->
                    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                        <div class="bg-yellow-600 px-4 py-3">
                            <h3 class="text-white font-semibold">Agendar Mantenimiento</h3>
                        </div>
                        <div class="p-4">
                            <form class="space-y-4" id="maintenanceForm">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Mantenimiento</label>
                                    <select name="tipo" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                                        <option value="preventivo">Preventivo</option>
                                        <option value="correctivo">Correctivo</option>
                                        <option value="emergencia">Emergencia</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                                    <input type="date" name="fecha" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora</label>
                                    <input type="time" name="hora" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                                    <select name="prioridad" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                                        <option value="baja">Baja</option>
                                        <option value="media">Media</option>
                                        <option value="alta">Alta</option>
                                        <option value="critica">Crítica</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                    <textarea name="descripcion" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm" placeholder="Describa el trabajo requerido..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-yellow-600 hover:bg-green-700 text-white py-2 px-4
                                rounded-md font-medium transition-colors text-sm">
                                    Agendar Mantenimiento
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Reportar Problemas -->
    <div id="issueModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Reportar Problema</h3>
                    <button class="close-modal text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form class="p-6 space-y-4" id="issueForm">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Componente</label>
                        <input type="text" id="modalComponent" name="componente" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Problema</label>
                        <select name="tipo_problema" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            <option>Fuga de aceite</option>
                            <option>Desgaste excesivo</option>
                            <option>Ruido anormal</option>
                            <option>Vibración</option>
                            <option>Mal funcionamiento</option>
                            <option>Daño visible</option>
                            <option>Otro</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Severidad</label>
                        <select name="severidad" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            <option value="baja">Baja - Operación normal</option>
                            <option value="media">Media - Requiere atención</option>
                            <option value="alta">Alta - Reparación urgente</option>
                            <option value="critica">Crítica - Detener operación</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción del Problema</label>
                        <textarea name="descripcion" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Describa detalladamente el problema encontrado..." required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Acción Recomendada</label>
                        <select name="accion_recomendada" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            <option>Agendar mantenimiento preventivo</option>
                            <option>Reparación inmediata</option>
                            <option>Reemplazo de componente</option>
                            <option>Monitoreo continuo</option>
                            <option>Inspección técnica especializada</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" class="close-modal px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-medium transition-colors">
                            Reportar Problema
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
