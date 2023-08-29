<?php

namespace App\View\Components\Presence;

use App\Models\Presence;
use Exception;
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

    /** @throws Exception */
    public function quantity(): ?int
    {
        $presence = Presence::query();

        return (match ($this->type) {
            'confirmed'   => fn () => $presence->where('is_confirmed', '=', true)->count(),
            'unconfirmed' => fn () => $presence->where('is_confirmed', '=', false)->count(),
            'conversion'  => fn () => $presence->get()->percentage(fn (Presence $presence) => $presence->is_confirmed) ?? 0,
            default       => throw new Exception('Type not found'),
        })();
    }

    /** @throws Exception */
    public function translate(): string
    {
        return match ($this->type) {
            'confirmed'   => __('Confirmado'),
            'unconfirmed' => __('Não Confirmado'),
            'conversion'  => __('Conversão'),
            default       => throw new Exception('Type not found'),
        };
    }
}
