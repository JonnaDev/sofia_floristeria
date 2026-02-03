@props([
'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Floristeria Sofia" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-10 items-center justify-center rounded-md overflow-hidden">
           <img src="{{ asset('images/logo.png') }}" alt="Sofía Florería" {{ $attributes }} />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Floristeria Sofia" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-10 items-center justify-center rounded-md overflow-hidden">
           <img src="{{ asset('images/logo.png') }}" alt="Sofía Florería" {{ $attributes }} />
        </x-slot>
    </flux:brand>
@endif
