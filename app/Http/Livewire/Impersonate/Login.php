<?php

namespace App\Http\Livewire\Impersonate;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\{Component, Redirector};
use WireUi\Traits\Actions;

class Login extends Component
{
    use Actions;

    public User $user;

    public function render(): string
    {
        return <<<'blade'
            <div>
                <x-button.circle primary wire:click="login">
                    <x-heroicon-s-arrow-right-on-rectangle class="w-5 h-5" />
                </x-button.circle>
            </div>
        blade;
    }

    public function login(): ?Redirector
    {
        if (user()->is($this->user)) {
            $this->notification()->warning('Você não pode se impersonar');

            return null;
        }

        if (!user()->isAdmin()) {
            $this->notification()->warning('Somente admins. podem se impersonar');

            return null;
        }

        session()->put('impersonate', [
            'from' => user()->id,
            'to'   => $this->user->id,
        ]);

        Auth::logout();
        Auth::login($this->user);

        return redirect(route('dashboard'));
    }
}
