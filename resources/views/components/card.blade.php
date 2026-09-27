@props(['title' => null, 'description' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden']) }}>
    @if($title || isset($header))
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div>
                @if($title)
                    <h3 class="text-lg font-semibold text-gray-900 leading-tight">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
                @endif
            </div>
            @if(isset($headerActions))
                <div class="flex items-center space-x-3">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end rounded-b-xl">
            {{ $footer }}
        </div>
    @endif
</div>
