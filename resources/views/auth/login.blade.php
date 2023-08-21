<x-guest-layout wrap>
    <form method="POST" class="p-2" action="{{ route('admin.login') }}">
        @csrf
        <div>
            <x-input label="Nome de Usuário"
                     id="username"
                     class="block mt-1 w-full"
                     type="text" name="username"
                     :value="old('username')"
                     required
                     autofocus
                     autocomplete="username"
            />
        </div>

        <div class="mt-4">
            <x-input label="Senha" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
        </div>
        <div class="block mt-4">
            <x-checkbox id="remember_me" label="Manter Conectado" name="remember" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-button type="submit" primary class="ml-3 w-full">
                {{ __('Acessar') }}
            </x-button>
        </div>
    </form>
</x-guest-layout>
