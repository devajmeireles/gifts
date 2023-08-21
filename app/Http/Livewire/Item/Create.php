<?php

namespace App\Http\Livewire\Item;

use App\Models\{Category, Item};
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

    public function updatedModal(bool $value): void
    {
        if ($value && Category::count() === 0) {
            $this->dialog()->info(
                'Sem categoria cadastrada!',
                'Você precisa cadastrar uma categoria antes de criar um item.'
            );

            $this->modal = false;
        }
    }

    public function rules(): array
    {
        return [
            'item.category_id' => ['required', Rule::exists('categories', 'id')],
            'item.name'        => ['required', 'string', 'max:255', Rule::unique('items', 'name')],
            'item.description' => ['nullable', 'max:255'],
            'item.reference'   => ['nullable', 'string', 'max:255'],
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

            $this->emitUp('item::index::refresh');
            $this->notification()->success('Item criado com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        } finally {
            $this->item();
        }

        $this->notification()->error('Erro ao criar item!');
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
