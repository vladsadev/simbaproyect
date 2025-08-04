<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Agregar Equipo') }}
            </h2>
        </div>
    </x-slot>


    <x-panels.main>

            <x-forms.form method="POST" action="/jobs">
                <x-forms.input label="Marca" name="location" placeholder="Toyota"/>
                <x-forms.input label="Modelo" name="location" placeholder="S1400 "/>
                <x-forms.input label="Tipo" name="location" placeholder="Excavadora"/>
                <x-forms.select label="Tipo" name="tipo">
                    @foreach($eType as $e)
                        <option> Operador 2</option>
                    @endforeach
                </x-forms.select>
                <x-forms.input label="URL" name="url" placeholder="https://qualcomsrl.com"/>
                <x-forms.divider/>
                <x-forms.button class="cursor-pointer"> Guardar Maquina</x-forms.button>
            </x-forms.form>

    </x-panels.main>

</x-app-layout>
