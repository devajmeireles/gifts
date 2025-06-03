<?php

namespace App\Livewire\Category;

use App\Livewire\Traits\Alert;
use App\Models\Category;
use Exception;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Delete extends Component
{
    use Alert;

    public Category $category;

    public function render(): string
    {
        return <<<'blade'
        <div> 
            <x-button.circle icon="trash" color="red" wire:click="confirm" />  
        </div>
        blade;
    }

    #[Renderless]
    public function confirm(): void
    {
        $this->question()
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        if (($count = $this->category->items->count()) > 0) {
            $this->warning("Essa categoria tem itens ($count)", 'Impossível Excluir!');

            return;
        }

        try {
            $this->category->delete();

            $this->dispatch('deleted');

            $this->success();

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->error();
    }
}
