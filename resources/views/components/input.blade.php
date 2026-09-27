@props(['disabled' => false, 'error' => false])

@php
$classes = 'block w-full rounded-lg sm:text-sm py-2.5 px-3 transition-colors duration-200 outline-none ';
if ($error) {
    $classes .= 'border-red-500 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 shadow-sm';
} else {
    $classes .= 'border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border';
}
@endphp

@if($attributes->get('type') === 'password')
<div class="relative" x-data="{ show: false }">
    <input :type="show ? 'text' : 'password'" {{ $disabled ? 'disabled' : '' }} {!! $attributes->except('type')->merge(['class' => $classes . ' pr-10']) !!}>
    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        <svg x-show="show" style="display:none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.51-3.14m2.164-2.164A9.97 9.97 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.06 10.06 0 01-2.16 3.14M15 12a3 3 0 01-3 3m-3-3a3 3 0 013-3m0 0L2 2l20 20" />
        </svg>
    </button>
</div>
@else
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $classes]) !!}>
@endif
