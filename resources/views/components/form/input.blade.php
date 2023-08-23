@props([
    'divClass' => '',
    'id' => '',
    'labelClass' => '',
    'label' => '',
    'type' => 'text',
    'inputDivClass' => '',
])

<div class="{{ $divClass }}">
    <label for="{{ $id }}" class="{{ $labelClass }}">{{ $label }}</label>
    <div class="{{ $inputDivClass }}">
        <input type={{ $type }} {{ $attributes->merge(['class' => 'form-control']) }}>
    </div>
</div>
