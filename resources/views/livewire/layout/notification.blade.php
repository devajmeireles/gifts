<x-slide title="Notificações">
    <div @notification.window="$wire.call('load')"></div>
    <div class="justify-center items-center" wire:loading.flex wire:target="load">
        <x-preloader />
    </div>
    <div wire:loading.remove>
        @if (!empty($notifications) && !user()->isGuest())
            <div class="flex justify-end mb-4">
                <x-button.circle sm
                                 red
                                 icon="trash"
                                 x-on:click="slide = false; $wire.call('clear');"
                />
            </div>
        @endif
        <div class="space-y-2">
            @php /** @var Illuminate\Notifications\DatabaseNotification $notification */ @endphp
            @forelse ($notifications as $notification)
                <x-alert>
                    {!! $notification['data']['message'] !!}
                </x-alert>
            @empty
                <x-alert gray center>
                    {{ __('Nenhuma notificação encontrada.') }}
                </x-alert>
            @endforelse
        </div>
    </div>
</x-slide>
