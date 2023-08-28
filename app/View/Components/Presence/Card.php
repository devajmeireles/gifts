<?php

namespace App\View\Components\Presence;

use App\Models\Presence;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public string $type,
    ) {
    }

    public function render(): View
    {
        return view('components.presence.card');
    }

    public function quantity(): int
    {
        $presence = Presence::query();

        return (match ($this->type) {
            'confirmed'   => fn () => $presence->where('is_confirmed', '=', true)->count(),
            'unconfirmed' => fn () => $presence->where('is_confirmed', '=', false)->count(),
            'conversion'  => fn () => $presence->get()->percentage(fn (Presence $presence) => $presence->is_confirmed),
        })();
    }

    public function translate(): string
    {
        return match ($this->type) {
            'confirmed'   => __('Confirmado'),
            'unconfirmed' => __('Não Confirmado'),
            'conversion'  => __('Conversão'),
        };
    }
}
