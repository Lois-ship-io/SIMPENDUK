@props(['variant' => 'primary'])

@php
    $classes = 'inline-flex items-center justify-center px-4 py-2 border text-sm font-semibold rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200 ';
    
    if ($variant === 'primary') {
        $classes .= 'border-transparent text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500';
    } elseif ($variant === 'secondary') {
        $classes .= 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-blue-500';
    } elseif ($variant === 'danger') {
        $classes .= 'border-transparent text-white bg-red-600 hover:bg-red-700 focus:ring-red-500';
    } elseif ($variant === 'success') {
        $classes .= 'border-transparent text-white bg-green-600 hover:bg-green-700 focus:ring-green-500';
    }
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
    {{ $slot }}
</button>
