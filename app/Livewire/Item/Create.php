<?php

namespace App\Livewire\Item;

use App\Livewire\Traits\Alert;
use App\Models\Item;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use Alert;

    public Item $item;

    public bool $modal = false;

    public bool $description = false;

    protected array $validationAttributes = [
        'item.category_id' => 'categoria',
        'item.name'        => 'nome',
        'item.description' => 'descrição',
        'item.reference'   => 'referência',
        'item.quantity'    => 'quantidade',
        'item.price'       => 'preço',
        'item.is_quotable' => 'cotas',
    ];

    public function mount(): void
    {
        $this->item();
    }

    public function render(): View
    {
        return view('livewire.item.create');
    }

    public function rules(): array
    {
        return [
            'item.category_id' => ['required', Rule::exists('categories', 'id')],
            'item.name'        => ['required', 'string', 'max:255', Rule::unique('items', 'name')],
            'item.description' => ['nullable', 'max:255'],
            'item.reference'   => ['nullable', 'url'],
            'item.quantity'    => ['required', 'integer'],
            'item.price'       => [Rule::when($this->item->is_quotable, ['required', 'numeric', ])],
            'item.is_quotable' => ['nullable', 'boolean'],
            'item.is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function create(): void
    {
        $this->validate();

        $this->modal = false;

        try {
            $this->item->save();

            $this->dispatch('created');

            $this->success();

            return;
        } catch (Exception $e) {
            report($e);
        } finally {
            $this->item();
        }

        $this->error();
    }

    private function item(): void
    {
        $this->item = new Item([
            'quantity'    => 1,
            'is_active'   => true,
            'is_quotable' => false,
            'price'       => 0,
        ]);
    }
}
