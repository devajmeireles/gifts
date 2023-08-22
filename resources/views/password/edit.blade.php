<x-app-layout>
    <div class="space-y-6">
        <x-card>
            @if (session('status') === 'password-updated')
                @if (config('app.demo'))
                    <x-alert>
                        {{ __('Não é possível alterar a senha no modo demonstração.') }}
                    </x-alert>
                @else
                    <x-alert green>
                        {{ __('Senha atualizada com sucesso.') }}
                    </x-alert>
                @endif
            @endif
            <form method="post" action="{{ route('admin.password.update') }}" class="space-y-4" id="password-update">
                @csrf
                @method('patch')
                <div>
                    <x-inputs.password label="Senha Atual"
                                       id="current_password"
                                       name="current_password"
                                       type="password"
                                       class="mt-1 block w-full"
                                       autocomplete="current-password"
                                       required
                    />
                </div>
                <div>
                    <x-inputs.password label="Nova Senha"
                                       id="password"
                                       name="password"
                                       type="password"
                                       class="mt-1 block w-full"
                                       autocomplete="new-password"
                                       required
                    />
                </div>
                <div>
                    <x-inputs.password label="Confirme a Nova Senha"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       type="password"
                                       class="mt-1 block w-full"
                                       autocomplete="new-password"
                                       required
                    />
                </div>
                <div class="flex items-center gap-4">
                    <x-button type="submit" label="Salvar" primary/>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
