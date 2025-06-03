<?php

namespace App\Livewire\Traits;

use TallStackUi\Foundation\Interactions\Dialog;
use TallStackUi\Traits\Interactions;

trait Alert
{
    use Interactions;

    public function success(string $description = 'Procedimento realizado com sucesso.', string $title = 'Pronto!'): void
    {
        $this->dialog()
            ->success(__($title), __($description))
            ->send();
    }

    public function error(string $description = 'Algo deu errado!', string $title = 'Ops!'): void
    {
        $this->dialog()
            ->error(__($title), __($description))
            ->send();
    }

    public function warning(string $description = 'Ei! Atenção.', string $title = 'Ops!'): void
    {
        $this->dialog()
            ->warning(__($title), __($description))
            ->send();
    }

    public function info(string $description = 'Ops! Preste atenção nisso.', string $title = 'Atenção!'): void
    {
        $this->dialog()
            ->info(__($title), __($description))
            ->send();
    }

    public function question(string $description = 'Você tem certeza?', string $title = 'Atenção!'): Dialog
    {
        return $this->dialog()->question(__($title), __($description));
    }
}
