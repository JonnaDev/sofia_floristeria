@props([
'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Floristeria Sofia" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-10 items-center justify-center rounded-md overflow-hidden">
            <img src="{{ asset('favicon.png') }}" alt="Floristeria Sofia" class="size-full object-contain" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Floristeria Sofia" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-10 items-center justify-center rounded-md overflow-hidden">
            <img src="{{ asset('favicon.png') }}" alt="Floristeria Sofia" class="size-full object-contain" />
        </x-slot>
    </flux:brand>
@endif
