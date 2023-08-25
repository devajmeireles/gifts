<?php

namespace App\Http\Livewire\Presence;

use App\Models\Presence;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Update extends Component
{
    use Actions;

    public ?Presence $presence = null;

    public bool $modal = false;

    public bool $observation = false;

    protected $listeners = [
        'presence::update::load' => 'load',
    ];

    protected array $validationAttributes = [
        'presence.name'         => 'nome',
        'presence.phone'        => 'telefone',
        'presence.is_confirmed' => 'presença confirmada',
        'presence.observation'  => 'observação',
    ];

    public function render(): View
    {
        return view('livewire.presence.update');
    }

    public function load(Presence $presence): void
    {
        $this->presence = $presence;
        $this->modal    = true;
        $this->presence->phone ??= '';
    }

    public function rules(): array
    {
        return [
            'presence.name'         => ['required', 'string', 'max:255', Rule::unique('presences', 'name')->ignore($this->presence->id)],
            'presence.phone'        => ['nullable', 'string', 'max:20'], //TODO: sincronizar regras
            'presence.is_confirmed' => ['required', 'boolean'],
            'presence.observation'  => [Rule::when($this->observation, ['required', 'string', 'max:1024'], ['nullable'])], //TODO: verificar outros Rule::when
        ];
    }

    public function update(): void
    {
        $this->validate();

        $this->modal = false;

        try {
            $this->presence->save();

            $this->emitUp('presence::index::refresh');
            $this->notification()->success('Presença atualizada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao atualizar a presença!');
    }
}
