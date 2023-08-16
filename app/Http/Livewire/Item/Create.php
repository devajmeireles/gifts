<?php

namespace App\Http\Livewire\Item;

use App\Models\Item;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public Item $item;

    public bool $modal = false;

    public function mount(): void
    {
        $this->item = new Item([
            'quantity'  => 1,
            'is_active' => true,
        ]);
    }

    public function render(): View
    {
        return view('livewire.item.create');
    }

    public function rules(): array
    {
        return [
            'item.category_id' => [
                'required',
                Rule::exists('categories', 'id'),
            ],
            'item.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('items', 'name'),
            ],
            'item.description' => [
                'nullable',
                'max:255',
            ],
            'item.reference' => [
                'nullable',
                'string',
                'max:255',
            ],
            'item.quantity' => [
                'required',
                'integer',
            ],
            'item.is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function create(): void
    {
        $this->validate();

        $this->modal = false;

        try {
            $this->item->save();

            $this->item = new Item();

            $this->emitUp('item::index::refresh');
            $this->notification()->success('Item criado com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao criar item!');
    }
}
