<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Exception;
use Livewire\Component;
use WireUi\Traits\Actions;

class Role extends Component
{
    use Actions;

    public User $user;

    public int $role;

    public function mount(): void
    {
        $this->role = $this->user->role->value;
    }

    public function render(): string
    {
        return <<<'blade'
        <div>
            <x-native-select :options="\App\Enums\UserRole::toSelect()"
                             wire:model="role"
                             option-label="label"
                             option-value="id"
            />
        </div>
blade;
    }

    public function updatedRole(): void
    {
        try {
            $this->user->update(['role' => $this->role]);

            $this->notification()->success('Regra atualizada com sucesso!');
        } catch (Exception $e) {
            report($e);

            $this->notification()->error('Erro ao atualizar a regra!');
        }
    }
}
