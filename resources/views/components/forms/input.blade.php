@props(['label'=>null, 'name'])

@php
    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
//        'class' => 'rounded-xl bg-blue-500/10 border border-white/40 px-2 py-2 w-full focus:outline-2 focus:outline-red-500',
        'class' => 'px-2 py-2 w-full rounded-xl border-1 focus:border-blue-700 focus:ring-0',
        'value' => old($name)
    ];
@endphp

<x-forms.field :$label :$name>

    <input {{ $attributes($defaults) }}>

</x-forms.field>
{{--focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600--}}
