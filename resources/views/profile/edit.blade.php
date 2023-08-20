<x-app-layout>
    <div class="space-y-6">
        <x-card>
            @if (session('status') === 'profile-updated')
                <x-alert green>
                    {{ __('Perfil atualizado com sucesso.') }}
                </x-alert>
            @endif
            <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-4" id="profile-update">
                @csrf
                @method('patch')
                <div>
                    <x-input label="Nome"
                             id="name"
                             name="name"
                             type="text"
                             class="mt-1 block w-full"
                             :value="old('name', $user?->name)"
                             required
                             autofocus
                             autocomplete="name" />
                </div>
                <div>
                    <x-input label="Nome de Usuário"
                             id="username"
                             name="username"
                             type="text"
                             class="mt-1 block w-full"
                             :value="old('username', $user?->username)"
                             disabled
                             autocomplete="username"
                    />
                </div>
                <div class="flex items-center gap-4">
                    <x-button type="submit" label="Salvar" primary />
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
