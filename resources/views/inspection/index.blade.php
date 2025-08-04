<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inspecciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-forms.form method="POST" action="/login" enctype="multipart/form-data">
                    <x-forms.input label="Your Email" name="email" type="email"/>
                    <x-forms.input label="Password" name="password" type="password"/>

                    <x-forms.divider/>

                    <x-forms.button class="hover:bg-white/40">Log In</x-forms.button>

                </x-forms.form>
            </div>
        </div>
    </div>
</x-app-layout>
