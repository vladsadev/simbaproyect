<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use App\Models\Inspection;
use App\Models\InspectionIssue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InspectionForm extends Component
{
    // Propiedades públicas (reactivas)
    public Equipment $equipment;
    public $observations = '';
    public $checkedItems = [];
    public $reportedIssues = [];
    public $epp = false;

    // Modal de problemas
    public $showIssueModal = false;
    public $currentIssueComponent = '';
    public $currentIssue = [
        'component' => '',
        'tipo_problema' => '',
        'severidad' => 'media',
        'descripcion' => '',
        'accion_recomendada' => 'Monitoreo continuo'
    ];

    // Items de inspección
    public $inspectionItems = [
        'cuchara' => 'Revisar el estado de la cuchara',
        'llantas' => 'Revisar el estado de las llantas',
        'articulacion' => 'Revisar engrase en la articulación central superior e inferior',
        'cilindro' => 'Revisar engrase en cilindro de dirección',
        'botellones' => 'Revisar engrase en los botellones de levante y volteo',
        'zbar' => 'Revisar engrase en Z-BAR',
        'dogbone' => 'Revisar engrase en DOG-BONE',
        'brazo' => 'Revisar engrase en el brazo/puño de cuchara',
        'tablero' => 'Verificar estado del tablero del control y display',
        'extintores' => 'Revisar extintores y verificar que esté cargado',
    ];

    // Reglas de validación
    protected $rules = [
        'currentIssue.tipo_problema' => 'required|string',
        'currentIssue.severidad' => 'required|in:baja,media,alta,critica',
        'currentIssue.descripcion' => 'required|string|min:10',
        'currentIssue.accion_recomendada' => 'required|string',
    ];

    protected $messages = [
        'currentIssue.tipo_problema.required' => 'Debe seleccionar el tipo de problema',
        'currentIssue.severidad.required' => 'Debe seleccionar la severidad',
        'currentIssue.descripcion.required' => 'Debe describir el problema',
        'currentIssue.descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
        'currentIssue.accion_recomendada.required' => 'Debe seleccionar una acción recomendada',
    ];

    // Montar el componente con el equipo
    public function mount(Equipment $equipment)
    {
        $this->equipment = $equipment;
    }

    // Propiedad computada para el progreso
    public function getProgressProperty()
    {
        $total = count($this->inspectionItems);
        $checked = count($this->checkedItems);
        return $total > 0 ? round(($checked / $total) * 100) : 0;
    }

    // Propiedad computada para el número de problemas
    public function getIssuesCountProperty()
    {
        return count($this->reportedIssues);
    }

    // Cuando se marca/desmarca un checkbox
    public function toggleItem($key)
    {
        if (in_array($key, $this->checkedItems)) {
            // Si estaba marcado, lo desmarcamos
            $this->checkedItems = array_values(array_diff($this->checkedItems, [$key]));
        } else {
            // Si no estaba marcado, lo marcamos
            $this->checkedItems[] = $key;
            // Si tenía un problema reportado, lo quitamos
            unset($this->reportedIssues[$key]);
        }
    }

    // Abrir modal para reportar problema
    public function openIssueModal($componentKey)
    {
        // Si el item está marcado como OK, lo desmarcamos
        if (in_array($componentKey, $this->checkedItems)) {
            $this->checkedItems = array_values(array_diff($this->checkedItems, [$componentKey]));
        }

        $this->currentIssueComponent = $componentKey;
        $this->currentIssue['component'] = $componentKey;

        // Si ya había un problema reportado para este componente, cargarlo
        if (isset($this->reportedIssues[$componentKey])) {
            $this->currentIssue = $this->reportedIssues[$componentKey];
        } else {
            // Resetear el formulario
            $this->currentIssue = [
                'component' => $componentKey,
                'tipo_problema' => '',
                'severidad' => 'media',
                'descripcion' => '',
                'accion_recomendada' => 'Monitoreo continuo'
            ];
        }

        $this->showIssueModal = true;
    }

    // Cerrar modal
    public function closeIssueModal()
    {
        $this->showIssueModal = false;
        $this->reset(['currentIssue', 'currentIssueComponent']);
    }

    // Guardar problema reportado
    public function saveIssue()
    {
//        dd($this->currentIssue); // Ver qué datos llegan

        $this->validate();

        // Guardar en el array de problemas
        $this->reportedIssues[$this->currentIssueComponent] = $this->currentIssue;

        // Asegurarse de que el item no esté marcado como OK
        $this->checkedItems = array_values(array_diff($this->checkedItems, [$this->currentIssueComponent]));

        // Cerrar modal
        $this->closeIssueModal();

        // Mensaje de éxito
        session()->flash('issue_saved', 'Problema reportado correctamente');
    }

    // Eliminar un problema reportado
    public function removeIssue($componentKey)
    {
        unset($this->reportedIssues[$componentKey]);
        session()->flash('issue_removed', 'Problema eliminado');
    }

    // Enviar formulario completo
    public function submit()
    {
        // Validación personalizada
        if (count($this->checkedItems) === 0 && count($this->reportedIssues) === 0) {
            $this->addError('inspection', 'Debe revisar al menos un elemento o reportar problemas encontrados.');
            return;
        }

        DB::beginTransaction();

        try {
            // Crear la inspección
            $inspection = Inspection::create([
                'equipment_id' => $this->equipment->id,
                'user_id' => Auth::id(),
                'inspection_date' => now(),
                'status' => $this->determineStatus(),
                'observations' => $this->observations,
                // Guardar estado de cada checkbox
                'cuchara_checked' => in_array('cuchara', $this->checkedItems),
                'llantas_checked' => in_array('llantas', $this->checkedItems),
                'articulacion_checked' => in_array('articulacion', $this->checkedItems),
                'cilindro_checked' => in_array('cilindro', $this->checkedItems),
                'botellones_checked' => in_array('botellones', $this->checkedItems),
                'zbar_checked' => in_array('zbar', $this->checkedItems),
                'dogbone_checked' => in_array('dogbone', $this->checkedItems),
                'brazo_checked' => in_array('brazo', $this->checkedItems),
                'tablero_checked' => in_array('tablero', $this->checkedItems),
                'extintores_checked' => in_array('extintores', $this->checkedItems),
                'epp_complete' => $this->epp,
            ]);

            // AGREGAR ESTA PARTE - Guardar los problemas reportados
            foreach ($this->reportedIssues as $issue) {
                InspectionIssue::create([
                    'inspection_id' => $inspection->id,
                    'user_id' => Auth::id(),
                    'component' => $issue['component'],
                    'issue_type' => $issue['tipo_problema'],
                    'severity' => $issue['severidad'],
                    'description' => $issue['descripcion'],
                    'recommended_action' => $issue['accion_recomendada'],
                    'reported_at' => now(),
                    'status' => 'abierto'
                ]);
            }

            DB::commit();

            // Log para verificar
            \Log::info('Inspección creada con issues:', [
                'inspection_id' => $inspection->id,
                'total_issues' => count($this->reportedIssues)
            ]);

            session()->flash('success', 'Inspección guardada exitosamente');

            return redirect()->route('equipment.show', $this->equipment);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error al guardar inspección:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            $this->addError('save', 'Error: ' . $e->getMessage());
        }
    }

    // Determinar el estado basado en los problemas
    private function determineStatus()
    {
        if (count($this->reportedIssues) === 0) {
            return 'completada';
        }

        // Verificar si hay problemas críticos
        foreach ($this->reportedIssues as $issue) {
            if ($issue['severidad'] === 'critica') {
                return 'requiere_atencion_urgente';
            }
        }

        return 'completada_con_observaciones';
    }

    // Método de renderizado
    public function render()
    {
        return view('livewire.inspection-form');
    }
}
