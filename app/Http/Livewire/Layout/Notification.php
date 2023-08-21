<?php

namespace App\Http\Livewire\Layout;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Collection;
use Livewire\Component;
use WireUi\Traits\Actions;

class Notification extends Component
{
    use Actions;

    public ?Collection $notifications = null;

    protected $listeners = [
        'notification::load' => 'load',
    ];

    public function render(): View
    {
        return view('livewire.layout.notification');
    }

    public function load(): void
    {
        $this->notifications = DatabaseNotification::get()
            ->lazy()
            ->each(fn (DatabaseNotification $notification) => $notification->markAsRead())
            ->collect();
    }

    public function clear(): void
    {
        try {
            DatabaseNotification::query()->delete();

            $this->notification()->success('Notificações apagadas com sucesso!');

            $this->notifications = null;

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao limpar notificações!');
    }
}
