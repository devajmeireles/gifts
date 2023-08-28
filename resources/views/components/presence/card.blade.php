<div class="col-span-1">
    <x-card>
        <div class="ml-4 p-2">
            <div class="flex items-center justify-start">
                <div class="flex-shrink-0 rounded p-2 bg-primary-100">
                    <p class="text-3xl font-bold text-primary-600">
                        {{ $quantity() }}
                        @if ($type === 'conversion')
                            %
                        @endif
                    </p>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold leading-6 text-md text-primary">
                        {{ $translate() }}
                    </h3>
                </div>
            </div>
        </div>
    </x-card>
</div>
