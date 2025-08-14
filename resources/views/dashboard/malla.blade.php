<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Malla de Perforaciones') }}
        </h2>
    </x-slot>

    <x-panels.main>
        <div class="bg-white py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto items-center flex max-w-2xl lex-col-reverse justify-between gap-16 lg:mx-0
                lg:max-w-none
                lg:flex-row">
                    <div class="w-full lg:max-w-xl lg:flex-auto py-10">
                        <x-forms.form method="POST" action="{{route('equipment.store')}}" class="max-w-4xl px-3 md:px-2">
                            <h3 class="text-xl font-bold text-blue-main">Campos Obligatorios</h3>
                            <div class="">
                                <x-forms.input label="Código" name="code" placeholder="EXC-001"/>
                                <x-forms.input label="Marca" name="brand" placeholder="Caterpillar"/>
                                <x-forms.input label="Modelo" name="model" placeholder="S7D"/>
                                <x-forms.input label="Año" name="year" placeholder="2024"/>
                            </div>

                        </x-forms.form>

                        <div class="mt-16 flex border-t border-gray-100 pt-8">
                            <x-link-btn variant="danger"> Acciones de administrador</x-link-btn>
                        </div>
                    </div>

                    <!-- Desktop lado derecho, mobile - superior -->
                    <div class="w-full lg:max-w-lg lg:flex-auto">
                        <h4 class="font-semibold text-gray-900 text-lg xl:text-2xl">
                            Malla del día </h4>
                        <div class="mt-2 text-base lg:text-lg text-gray-600">
                            Fecha y lugar: <span> Fecha: {{ now()->format('d/m/Y') }}</span> - <span>Mina Sur</span>
                        </div>
                        <img src="{{Vite::asset('resources/images/malla1.png')}}" alt="" class="mt-10 aspect-6/5 w-full
                        rounded-2xl
                        object-cover outline-1
                        -outline-offset-1
                         outline-black/5 lg:aspect-auto lg:h-138"/>
                    </div>


                </div>
            </div>
        </div>


    </x-panels.main>

</x-app-layout>
