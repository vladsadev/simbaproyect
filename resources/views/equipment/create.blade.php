<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Agregar Equipo') }}
            </h2>

            <x-link-btn href="{{route('equipment.index')}}">Volver</x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>
        {{--        'equipment_type_id' => ['required', 'exists:equipment_types'],--}}
        {{--        'code' => ['required'],--}}
        {{--        'brand' => ['required'],--}}
        {{--        'model' => ['required'],--}}
        {{--        'year' => ['required', 'integer'],--}}
        {{--        'status' => ['required'],--}}
        {{--        'hours_worked' => ['required', 'numeric'],--}}
        <x-forms.form method="POST" action="{{route('equipment.store')}}">
            <x-forms.input label="Código" name="code" placeholder="SK23"/>
            <x-forms.input label="Marca" name="brand" placeholder="Caterpillar"/>
            <x-forms.input label="Modelo" name="model" placeholder="917u"/>
            <x-forms.input label="Año" name="year" placeholder="2021 "/>
            <x-forms.input label="Estado" name="status" placeholder="operativa"/>
            <x-forms.input label="Horas Trabajadas" name="hours_worked" placeholder="200 "/>
            <x-forms.divider/>
            <x-forms.button class="cursor-pointer"> Guardar Maquina</x-forms.button>
        </x-forms.form>

    </x-panels.main>

</x-app-layout>
