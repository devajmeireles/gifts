<?php

namespace App\Http\Livewire\Presence;

use App\Models\Presence;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public Presence $presence;

    public bool $modal = false;

    public bool $observation = false;

    protected array $validationAttributes = [
        'presence.name'         => 'nome',
        'presence.phone'        => 'telefone',
        'presence.is_confirmed' => 'presença confirmada',
        'presence.observation'  => 'observação',
    ];

    public function mount(): void
    {
        $this->presence();
    }

    public function render(): View
    {
        return view('livewire.presence.create');
    }

    public function rules(): array
    {
        return [
            'presence.name'         => ['required', 'string', 'max:255', Rule::unique('presences', 'name')],
            'presence.phone'        => ['nullable', 'string', 'max:20'], //TODO: sincronizar regras
            'presence.is_confirmed' => ['required', 'boolean'],
            'presence.observation'  => [Rule::when($this->observation, ['required', 'string', 'max:1024'], ['nullable'])], //TODO: verificar outros Rule::when
        ];
    }

    public function create(): void
    {
        $this->validate();

        $this->modal = false;

        try {
            $this->presence->save();

            $this->emitUp('presence::index::refresh');
            $this->notification()->success('Presença criada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        } finally {
            $this->presence();
        }

        $this->notification()->error('Erro ao criar a presença!');
    }

    private function presence(): void
    {
        $this->presence = new Presence(['phone' => '', 'is_confirmed' => true]);
    }
}
