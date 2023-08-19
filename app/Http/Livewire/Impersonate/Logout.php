<?php

namespace App\Http\Livewire\Impersonate;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\{Component, Redirector};
use WireUi\Traits\Actions;

class Logout extends Component
{
    use Actions;

    public function render(): string
    {
        return <<<'blade'
            <div>
                <x-button.circle red wire:click="logout">
                    <x-heroicon-s-arrow-right-on-rectangle class="w-5 h-5" />
                </x-button.circle>
            </div>
        blade;
    }

    public function logout(): mixed
    {
        if (!session()->has('impersonate')) {
            $this->notification()->warning('Você não está impersonando');

            return null;
        }

        Auth::logout();
        Auth::login(User::find(session()->get('impersonate.from')));

        session()->forget('impersonate');

        return redirect(route('admin.dashboard'));
    }
}
