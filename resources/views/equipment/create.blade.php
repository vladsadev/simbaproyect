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

        <x-forms.form method="POST" action="{{route('equipment.store')}}">
            <div class=" bg-black flex gap-3 w-full">
                <!-- Código del equipo -->
                <x-forms.input label="Código" name="code" placeholder="EXC-001" class="w-full" />
                <!-- Marca -->
                <x-forms.input label="Marca" name="brand" placeholder="Caterpillar" class="flex-1"/>
                <!-- Modelo -->
                <x-forms.input label="Modelo" name="model" placeholder="S7D" class=""/>
            </div>
            <!-- Año -->
            <x-forms.input label="Año" name="year" placeholder="2024"/>
            <!-- Estado -->
            <x-forms.select label="Estado" name="status">
                <option value="active">Operativa</option>
                <option value="maintenance">En Mantenimiento</option>
                <option value="inactive">Inactiva</option>
            </x-forms.select>

            <!-- Tipo de Equipo -->
            <x-forms.select label="Tipo de Equipo" name="equipment_type_id">
                @foreach($eTypes as $eType)
                    <option value="{{ $eType->id }}">{{ $eType->name }}</option>
                @endforeach
            </x-forms.select>



            <x-forms.divider/>
            <x-forms.button class="cursor-pointer">Guardar Equipo</x-forms.button>
        </x-forms.form>

    </x-panels.main>

</x-app-layout>
