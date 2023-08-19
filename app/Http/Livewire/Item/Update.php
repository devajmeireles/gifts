<?php

namespace App\Http\Livewire\Item;

use App\Models\Item;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Update extends Component
{
    use Actions;

    public Item $item;

    public bool $modal = false;

    protected $listeners = [
        'item::update::load' => 'load',
    ];

    public function render(): View
    {
        return view('livewire.item.update');
    }

    public function load(Item $item): void
    {
        $this->item  = $item;
        $this->modal = true;
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
                Rule::unique('items', 'name')
                    ->ignore($this->item->id),
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
            'item.price' => [
                Rule::when($this->item->is_quotable, [
                    'required',
                    'numeric',
                ]),
            ],
            'item.is_quotable' => [
                'nullable',
                'boolean',
            ],
            'item.is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function update(): void
    {
        $this->validate();

        $this->modal = false;

        try {
            $this->item->save();

            $this->emitUp('item::index::refresh');
            $this->notification()->success('Item atualizado com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao atualizar item!');
    }
}
