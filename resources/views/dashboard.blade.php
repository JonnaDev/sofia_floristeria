<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-col gap-4 rounded-xl">

        <div class="grid auto-rows-min gap-4 md:grid-cols-3 bg-white dark:bg-zinc-800">

            {{-- Flores --}}
            <div class="relative aspect-video rounded-xl border border-neutral-200 dark:border-pink-400 shadow-xl">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />

                <div class="relative z-10 h-full flex flex-col items-center justify-center gap-1 text-center">
                    <h1 class="text-3xl font-bold font-sans text-zinc-800 dark:text-white">
                        Flores Totales
                    </h1>
                    <p class="text-3xl font-bold text-pink-500">
                        {{ $flowersCount }}
                    </p>
                </div>
            </div>

            {{-- Categorías --}}
            <div class="relative aspect-video rounded-xl border border-neutral-200 dark:border-pink-400 shadow-xl">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />

                <div class="relative z-10 h-full flex flex-col items-center justify-center gap-1 text-center">
                    <h1 class="text-3xl font-bold font-sans text-zinc-800 dark:text-white">
                        Categorías Totales
                    </h1>
                    <p class="text-3xl font-bold text-pink-500">
                        {{ $categoriesCount }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
