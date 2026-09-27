@props(['disabled' => false, 'error' => false])

@php
$classes = 'block w-full rounded-lg sm:text-sm py-2.5 px-3 transition-colors duration-200 outline-none ';
if ($error) {
    $classes .= 'border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 shadow-sm';
} else {
    $classes .= 'border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border';
}
@endphp

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $classes]) !!}>
    {{ $slot }}
</select>
