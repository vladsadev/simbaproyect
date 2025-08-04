<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Principal') }}
        </h2>
    </x-slot>

    <x-forms.form method="POST" action="/jobs">

        <x-forms.input label="Title" name="title" placeholder="Video Producer"/>
        <x-forms.input label="Salary" name="salary" placeholder="Bs.- 7.000"/>
        <x-forms.input label="Location" name="location" placeholder="Bolivia, Usa, etc. "/>

        <x-forms.select label="Schedule" name="schedule">
            <option> one </option>
            <option> Full Time </option>
        </x-forms.select>

        <x-forms.input label="URL" name="url" placeholder="https://qualcomsrl.com"/>
        <x-forms.checkbox label="Feature (Costs Extra)" name="featured"/>

        <x-forms.divider/>

        <x-forms.input label="Tags (comma separated)" name="tags" placeholder="frontend, backend, web"/>


        <x-forms.button class="cursor-pointer" > Create Job </x-forms.button>

    </x-forms.form>

</x-app-layout>
