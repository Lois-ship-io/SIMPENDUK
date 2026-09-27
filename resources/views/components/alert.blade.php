@props(['type' => 'success', 'message'])

@php
    $bgClass = '';
    $textClass = '';
    $iconClass = '';
    
    if ($type === 'success') {
        $bgClass = 'bg-green-50 border-green-200';
        $textClass = 'text-green-800';
        $iconClass = 'text-green-400';
    } elseif ($type === 'error') {
        $bgClass = 'bg-red-50 border-red-200';
        $textClass = 'text-red-800';
        $iconClass = 'text-red-400';
    } elseif ($type === 'warning') {
        $bgClass = 'bg-yellow-50 border-yellow-200';
        $textClass = 'text-yellow-800';
        $iconClass = 'text-yellow-400';
    }
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg border p-4 mb-6 $bgClass"]) }}>
    <div class="flex">
        <div class="flex-shrink-0">
            @if($type === 'success')
                <svg class="h-5 w-5 {{ $iconClass }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            @elseif($type === 'error')
                <svg class="h-5 w-5 {{ $iconClass }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            @endif
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium {{ $textClass }}">
                {{ $message }}
            </p>
        </div>
    </div>
</div>
