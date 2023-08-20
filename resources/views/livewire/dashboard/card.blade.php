<div class="col-span-full sm:col-span-1" wire:init="load">
    <x-card wire:loading>
        <div class="flex animate-pulse space-x-4">
            <div class="flex-1 py-1 space-y-6">
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                        <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                        <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                    </div>
                    <div class="h-2 rounded bg-primary-200"></div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                        <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                        <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                    </div>
                </div>
            </div>
        </div>
    </x-card>
    <x-card wire:loading.remove>
        <div class="ml-4 p-2">
            <div class="flex items-center justify-start">
                <div class="flex-shrink-0">
                    <p class="text-3xl font-semibold text-primary-800">
                        {{ $this->quantity }}
                    </p>
                </div>
                <div class="ml-4">
                    <h3 class="text-md font-semibold leading-6 text-primary">
                        {{ $this->type->translate() }}
                    </h3>
                </div>
            </div>
        </div>
    </x-card>
</div>
