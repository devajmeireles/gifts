<x-slide title="Notificações">
    <div @notification.window="$wire.call('load')"></div>
    <div class="items-center justify-center" wire:loading.flex wire:target="load">
        <x-preloader />
    </div>
    <div wire:loading.remove>
        @if ($notifications?->isNotEmpty() && !user()->isGuest())
            <div class="mb-4 flex justify-end">
                <x-button.circle sm
                                 red
                                 icon="trash"
                                 x-on:click="slide = false; $wire.call('clear');"
                />
            </div>
        @endif
        <div class="space-y-2">
            @php /** @var Illuminate\Notifications\DatabaseNotification $notification */ @endphp
            @forelse ($notifications ?? [] as $notification)
                <x-alert outline>
                    {!! $notification->data['message'] !!}
                    <div class="mt-2 flex justify-end">
                        <x-badge flat primary>
                            {{ $notification->created_at->format('d/m/Y H:i') }}
                        </x-badge>
                    </div>
                </x-alert>
            @empty
                <x-alert gray center>
                    {{ __('Nenhuma notificação encontrada.') }}
                </x-alert>
            @endforelse
        </div>
    </div>
</x-slide>
