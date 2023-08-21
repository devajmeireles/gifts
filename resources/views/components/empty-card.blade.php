<x-card>
    <div class="p-8 flex justify-center items-center">
        <div class="inline-flex gap-2">
            <p class="text-lg sm:text-2xl font-semibold leading-6">
                {{ $text ?? $slot }}
            </p>
        </div>
    </div>
</x-card>
