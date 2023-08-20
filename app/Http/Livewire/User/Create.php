<?php

namespace App\Http\Livewire\User;

use App\Enums\UserRole;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public User $user;

    public bool $modal = false;

    public ?int $role = null;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    protected array $validationAttributes = [
        'user.name'     => 'nome',
        'user.username' => 'usuário',
    ];

    public function mount(): void
    {
        $this->user = new User();
        $this->role = UserRole::User->value;
    }

    public function render(): View
    {
        return view('livewire.user.create');
    }

    public function updatedUser(mixed $value, mixed $property): void
    {
        if ($property === 'name') {
            $this->user->username = str($value)->snake()->value();
        }
    }

    public function rules(): array
    {
        return [
            'user.name'     => ['required', 'string', 'min:2', 'max:255'],
            'user.username' => ['required', 'string', 'min:2', 'max:255', Rule::unique('users', 'username')],
            'role'          => ['required', 'integer', Rule::enum(UserRole::class)],
            'password'      => ['required', Password::default(), 'confirmed'],
        ];
    }

    public function random(): void
    {
        $this->password = $this->password_confirmation = Str::password(8, symbols: false);
    }

    public function create(): void
    {
        $this->validate();

        $this->modal = false;

        try {
            $this->user->role     = UserRole::from($this->role);
            $this->user->password = Hash::make($this->password);
            $this->user->save();

            $this->emitUp('user::index::refresh');
            $this->notification()->success('Usuário criado com sucesso!');

            return;
        } catch (Exception $e) {
            ray($e->getMessage());
            report($e);
        }

        $this->notification()->error('Erro ao criar o usuário!');
    }
}
