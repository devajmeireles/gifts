<?php

namespace App\Http\Livewire\Layout;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;
use WireUi\Traits\Actions;

class Notification extends Component
{
    use Actions;

    public array $notifications = [];

    protected $listeners = [
        'notification::load' => 'load',
    ];

    public function render(): View
    {
        return view('livewire.layout.notification');
    }

    public function load(): void
    {
        sleep(1);

        $this->notifications = [];

        DatabaseNotification::get()
            ->lazy()
            ->each(fn (DatabaseNotification $notification) => $notification->markAsRead())
            ->each(fn (DatabaseNotification $notification) => $this->notifications[] = $notification->toArray());
    }

    public function clear(): void
    {
        try {
            DatabaseNotification::query()->delete();

            $this->notification()->success('Notificações apagadas com sucesso!');

            $this->notifications = [];

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao limpar notificações!');
    }
}
