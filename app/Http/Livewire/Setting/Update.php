<?php

namespace App\Http\Livewire\Setting;

use App\Models\Setting;
use App\Services\Settings\Facades\Settings;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class Update extends Component
{
    use Actions;

    public ?Setting $setting = null;

    public bool $modal = false;

    protected $listeners = [
        'setting::load' => 'load',
    ];

    public function mount(): void
    {
        if ($this->setting) {
            $this->setting->value = $this->setting->type === 'boolean' ? (bool)$this->setting->value : $this->setting->value;
        }
    }

    public function render(): View
    {
        return view('livewire.setting.update');
    }

    public function load(Setting $setting): void
    {
        $this->setting = $setting;
        $this->modal   = true;
    }

    public function rules(): array
    {
        return [
            'setting.key'   => ['required', 'string', 'max:255'],
            'setting.value' => ['nullable', 'max:255'],
        ];
    }

    public function update(): void
    {
        $this->validate();

        $this->modal = false;

        try {
            Settings::set($this->setting->key, $this->setting->value, $this->setting->type);

            $this->notification()->success('Configuração atualizada com sucesso!');
            $this->emitUp('setting::index::refresh');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao atualizar a configuração!');
    }
}
