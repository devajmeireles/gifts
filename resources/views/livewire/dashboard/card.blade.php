<div class="col-span-full sm:col-span-1" wire:init="load">
    <x-card wire:loading>
        <div class="animate-pulse flex space-x-4">
            <div class="flex-1 space-y-6 py-1">
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                        <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                        <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                    </div>
                    <div class="h-2 bg-slate-200 rounded"></div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                        <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                        <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </x-card>
    <x-card wire:loading.remove>
        <div class="ml-4 p-2">
            <div class="flex items-center justify-start">
                <div class="flex-shrink-0">
                    <p class="text-3xl text-indigo-800 font-semibold">
                        {{ $this->quantity }}
                    </p>
                </div>
                <div class="ml-4">
                    <h3 class="text-base font-semibold leading-6 text-indigo-600">
                        {{ $this->type->translate() }}
                    </h3>
                    <x-badge outline primary>
                        80% em Fraldas
                    </x-badge>
                </div>
            </div>
        </div>
    </x-card>
</div>
