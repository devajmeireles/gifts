<?php

namespace App\Livewire\Impersonate;

use App\Models\User;
use Illuminate\Support\Facades\{Auth, Session};
use Livewire\{Component};

class Logout extends Component
{
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
        if (($impersonate = Session::get('impersonate')) === null) {
            $this->notification()->warning('Você não está impersonando');

            return null;
        }

        Auth::logout();
        Auth::login(User::find($impersonate['from']));

        Session::forget('impersonate');

        return redirect(route('admin.dashboard'));
    }
}
