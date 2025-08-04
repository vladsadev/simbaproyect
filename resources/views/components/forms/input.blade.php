@props(['label'=>null, 'name'])

@php
    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' => 'rounded-xl bg-blue-500/10 border border-white/40 px-5 py-4 w-full',
        'value' => old($name)
    ];
@endphp

<x-forms.field :$label :$name>

    <input {{ $attributes($defaults) }}>

</x-forms.field>
