<div class="max-w-7xl mx-auto">
    {{-- Mensajes Flash --}}
    @if (session()->has('issue_saved'))
        <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-lg">
            {{ session('issue_saved') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            {{-- Panel Principal - Lista de Inspección --}}
            <div class="lg:col-span-3 space-y-4">
                {{-- Header con progreso --}}
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold">Lista de Inspección General</h2>
                            <span class="text-sm">Fecha: {{ now()->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    {{-- Barra de progreso --}}
                    <div class="px-6 py-4 bg-gray-50">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progreso de inspección</span>
                            <span class="font-semibold">{{ count($checkedItems) }}/{{ count($inspectionItems) }} elementos revisados</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full transition-all duration-500
                                {{ $this->progress < 40 ? 'bg-red-500' : ($this->progress < 80 ? 'bg-yellow-500' : 'bg-green-500') }}"
                                 style="width: {{ $this->progress }}%">
                            </div>
                        </div>
                        @if($this->issuesCount > 0)
                            <div class="mt-2 text-sm text-red-600 font-medium">
                                ⚠️ {{ $this->issuesCount }} {{ $this->issuesCount == 1 ? 'problema reportado' : 'problemas reportados' }}
                            </div>
                        @endif
                    </div>

                    {{-- Lista de items de inspección --}}
                    <div class="p-6 space-y-3">
                        @foreach($inspectionItems as $key => $item)
                            <div class="inspection-item flex items-center justify-between p-4 rounded-lg border-2 transition-all duration-300
                                {{ in_array($key, $checkedItems) ? 'bg-green-50 border-green-400' :
                                   (isset($reportedIssues[$key]) ? 'bg-red-50 border-red-400' : 'bg-white border-gray-200 hover:border-gray-300') }}">

                                <div class="flex items-center flex-1">
                                    <input type="checkbox"
                                           wire:click="toggleItem('{{ $key }}')"
                                           id="check-{{ $key }}"
                                           @if(in_array($key, $checkedItems)) checked @endif
                                           @if(isset($reportedIssues[$key])) disabled @endif
                                           class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500 mr-3">

                                    <label for="check-{{ $key }}" class="text-gray-700 font-medium cursor-pointer flex-1">
                                        {{ $item }}
                                    </label>

                                    @if(isset($reportedIssues[$key]))
                                        <span class="ml-2 px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                            Problema: {{ ucfirst($reportedIssues[$key]['severidad']) }}
                                        </span>
                                    @elseif(in_array($key, $checkedItems))
                                        <span class="ml-2 text-green-600">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                    @endif
                                </div>

                                <button type="button"
                                        wire:click="openIssueModal('{{ $key }}')"
                                        class="ml-4 p-2 rounded-full transition-colors
                                        {{ isset($reportedIssues[$key]) ? 'text-red-600 hover:bg-red-100' : 'text-yellow-600 hover:bg-yellow-100' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach

                        {{-- EPP Section --}}
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg border-2 border-blue-200">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       wire:model="epp"
                                       class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mr-3">
                                <span class="font-semibold text-gray-700">Cumple con todos los EPP</span>
                                <span class="ml-2 text-sm text-gray-500">(Equipo de Protección Personal)</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Observaciones Generales --}}
                <div class="bg-white shadow-xl rounded-lg p-6">
                    <label for="observations" class="block text-lg font-semibold text-gray-700 mb-3">
                        Observaciones Generales
                    </label>
                    <textarea wire:model="observations"
                              id="observations"
                              rows="4"
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Ingrese observaciones adicionales sobre la inspección..."></textarea>
                </div>
            </div>

            {{-- Panel Lateral - Información --}}
            <div class="lg:col-span-2 space-y-4">
                {{-- Detalles del Equipo --}}
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="bg-yellow-600 px-4 py-3">
                        <h3 class="text-white font-semibold">Detalles del Equipo</h3>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-800 font-bold text-lg mb-2">
                            Código: {{ $equipment->code }}
                        </p>
                        <p class="text-gray-600 text-sm space-y-1">
                            <span class="block">• Marca: {{ $equipment->brand }}</span>
                            <span class="block">• Modelo: {{ $equipment->model }}</span>
                            <span class="block">• Año: {{ $equipment->year }}</span>
                            <span class="block">• Ubicación: {{ $equipment->location }}</span>
                        </p>
                    </div>
                </div>

                {{-- Detalles del Inspector --}}
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="bg-yellow-600 px-4 py-3">
                        <h3 class="text-white font-semibold">Detalles del Inspector</h3>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-800 font-bold">{{ Auth::user()->name }}</p>
                        <p class="text-gray-600 text-sm">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                {{-- Resumen de Problemas --}}
                @if(count($reportedIssues) > 0)
                    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                        <div class="bg-red-600 px-4 py-3">
                            <h3 class="text-white font-semibold">Problemas Reportados</h3>
                        </div>
                        <div class="p-4 space-y-2 max-h-64 overflow-y-auto">
                            @foreach($reportedIssues as $key => $issue)
                                <div class="text-sm border-l-4 border-red-500 pl-3 py-2">
                                    <div class="font-semibold text-gray-800">
                                        {{ $inspectionItems[$key] }}
                                    </div>
                                    <div class="text-gray-600">
                                        Severidad: <span class="font-medium text-red-600">{{ ucfirst($issue['severidad']) }}</span>
                                    </div>
                                    <button wire:click="removeIssue('{{ $key }}')"
                                            type="button"
                                            class="text-xs text-red-600 hover:underline mt-1">
                                        Eliminar
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Equipo de Protección Visual --}}
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="bg-blue-800 px-4 py-3">
                        <h3 class="text-white font-semibold">Equipo de Protección - Uso Obligatorio</h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-3 text-center">
                            <div class="text-sm">
                                <div class="text-3xl mb-1">👷</div>
                                <span class="text-gray-600">Casco</span>
                            </div>
                            <div class="text-sm">
                                <div class="text-3xl mb-1">🥾</div>
                                <span class="text-gray-600">Botas</span>
                            </div>
                            <div class="text-sm">
                                <div class="text-3xl mb-1">🧤</div>
                                <span class="text-gray-600">Guantes</span>
                            </div>
                            <div class="text-sm">
                                <div class="text-3xl mb-1">🦺</div>
                                <span class="text-gray-600">Chaleco</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mensajes de Error --}}
        @error('inspection')
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ $message }}
        </div>
        @enderror

        @error('save')
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ $message }}
        </div>
        @enderror

        {{-- Botones de Acción --}}
        <div class="mt-6 flex justify-between items-center">
            <div class="text-sm text-gray-600">
                <span class="font-medium">Estado: </span>
                @if(count($reportedIssues) > 0)
                    <span class="text-red-600">{{ count($reportedIssues) }} problemas por resolver</span>
                @elseif(count($checkedItems) == count($inspectionItems))
                    <span class="text-green-600">Inspección completa</span>
                @else
                    <span class="text-yellow-600">Inspección en progreso</span>
                @endif
            </div>

            <div class="space-x-3">
                <a href="{{ route('equipment.show', $equipment) }}"
                   class="inline-block px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors">
                    <span wire:loading.remove>Confirmar Inspección</span>
                    <span wire:loading>
                        <svg class="inline animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Guardando...
                    </span>
                </button>
            </div>
        </div>
    </form>

    {{-- Modal para Reportar Problemas --}}
    @if($showIssueModal)
        <div class="fixed inset-0 bg-blue-main/90 bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-gray-900">Reportar Problema</h3>
                        <button wire:click="closeIssueModal"
                                type="button"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Componente --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Componente</label>
                        <input type="text"
                               value="{{ $inspectionItems[$currentIssueComponent] ?? '' }}"
                               class="w-full rounded-md border-gray-300 bg-gray-200"
                               readonly>
                    </div>

                    {{-- Tipo de Problema --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Problema</label>
                        <select wire:model="currentIssue.tipo_problema"
                                class="w-full rounded-md border-gray-300 focus:border-red-500 focus:ring-red-500">
                            <option value="">Seleccione el tipo de problema</option>
                            <option value="fuga_aceite">Fuga de aceite</option>
                            <option value="desgaste">Desgaste excesivo</option>
                            <option value="ruido">Ruido anormal</option>
                            <option value="vibracion">Vibración</option>
                            <option value="mal_funcionamiento">Mal funcionamiento</option>
                            <option value="daño_visible">Daño visible</option>
                            <option value="otro">Otro</option>
                        </select>
                        @error('currentIssue.tipo_problema')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Severidad --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Severidad</label>
                        <select wire:model="currentIssue.severidad"
                                class="w-full rounded-md border-gray-300 focus:border-red-500 focus:ring-red-500">
                            <option value="baja">Baja - Operación normal</option>
                            <option value="media">Media - Requiere atención</option>
                            <option value="alta">Alta - Reparación urgente</option>
                            <option value="critica">Crítica - Detener operación</option>
                        </select>
                        @error('currentIssue.severidad')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción del Problema</label>
                        <textarea wire:model="currentIssue.descripcion"
                                  rows="3"
                                  class="w-full rounded-md border-gray-300 focus:border-red-500 focus:ring-red-500"
                                  placeholder="Describa detalladamente el problema encontrado..."></textarea>
                        @error('currentIssue.descripcion')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Acción Recomendada --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Acción Recomendada</label>
                        <select wire:model="currentIssue.accion_recomendada"
                                class="w-full rounded-md border-gray-300 focus:border-red-500 focus:ring-red-500">
                            <option value="Agendar mantenimiento preventivo">Agendar mantenimiento preventivo</option>
                            <option value="Reparación inmediata">Reparación inmediata</option>
                            <option value="Reemplazo de componente">Reemplazo de componente</option>
                            <option value="Monitoreo continuo">Monitoreo continuo</option>
                            <option value="Inspección técnica especializada">Inspección técnica especializada</option>
                        </select>
                        @error('currentIssue.accion_recomendada')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="sticky bottom-0 bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <button wire:click="closeIssueModal"
                                type="button"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                            Cancelar
                        </button>
                        <button wire:click="saveIssue"
                                type="button"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-not-allowed"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-medium transition-colors">
                            <span wire:loading.remove>Reportar Problema</span>
                            <span wire:loading>Guardando...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
