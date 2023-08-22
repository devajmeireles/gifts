<div>
    <div class="mb-4 flex items-center justify-end gap-2">
        @if (!($guest = user()->isGuest()))
            <livewire:signature.create />
        @endif
        <livewire:signature.filter />
    </div>
    <div class="mb-4">
        <x-input type="text"
                 placeholder="Pesquise alguma coisa..."
                 class="w-full"
                 wire:model.debounce.250ms="search"
        />
    </div>
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @php /** @var \App\Models\Signature $signature */ @endphp
        @forelse ($signatures as $signature)
            <div class="col-span-full sm:col-span-1">
                <x-card>
                    <div class="ml-4 p-2">
                        <div class="flex items-center justify-start">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full"
                                     src="{{ $signature->avatar() }}" alt="{{ $signature->name }}">
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">
                                    (#{{ $signature->id }}) {{ $signature->name }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    <a href="#">{{ $signature->item->name }}</a>
                                </p>
                                <x-badge outline primary>
                                    {{ $signature->created_at->format('d/m/Y H:i') }}
                                </x-badge>
                            </div>
                        </div>
                    </div>
                    @if (!$guest)
                        <div class="flex justify-end gap-1">
                            <livewire:signature.update :signature="$signature" :key="md5('update-'.$signature->id)" />
                            <livewire:signature.delete :signature="$signature" :key="md5('delete-'.$signature->id)" />
                        </div>
                    @endif
                </x-card>
            </div>
        @empty
            <div class="col-span-full">
                <x-empty-card text="Nenhuma assinatura encontrada" />
            </div>
        @endforelse
    </div>
    <x-pagination :items="$signatures" />
</div>
