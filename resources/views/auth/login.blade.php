<x-guest-layout wrap>
    @if (($demo = config('app.demo')))
        <x-alert outline center>
            <a href="https://github.com/devajmeireles/gifts"
               target="_blank"
               class="inline-flex items-center"
            >
                Código Fonte
                <x-heroicon-s-arrow-up-right class="ml-1 h-4 w-4"/>
            </a>
        </x-alert>
    @endif
    <form method="POST" action="{{ route('admin.login') }}" @class(['mt-4' => $demo])>
        @csrf
        <div>
            <x-input label="Nome de Usuário"
                     id="username"
                     class="mt-1 block w-full"
                     type="text" name="username"
                     :value="old('username', $username)"
                     required
                     autofocus
                     autocomplete="username"
            />
        </div>

        <div class="mt-4">
            <x-inputs.password label="Senha" id="password" class="mt-1 block w-full"
                               type="password"
                               name="password"
                               :value="$password"
                               required
                               autocomplete="current-password"/>
        </div>
        <div class="mt-4 block">
            <x-checkbox id="remember_me" label="Manter Conectado" name="remember"/>
        </div>
        <div class="mt-4 flex items-center justify-end">
            <x-button type="submit" primary class="w-full uppercase">
                {{ __('Acessar') }}
            </x-button>
        </div>
    </form>
</x-guest-layout>
