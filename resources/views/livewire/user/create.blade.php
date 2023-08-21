<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none sm:justify-end">
    <x-button label="Adicionar"
              primary
              wire:click="$toggle('modal')"
    />
    <x-modal.card title="Criação de Usuário" wire:model.defer="modal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="col-span-full">
                <x-native-select label="Regra"
                                 :options="\App\Enums\UserRole::toSelect()"
                                 option-label="label"
                                 option-value="id"
                                 wire:model="role"
                />
            </div>

            <x-input label="Nome" wire:model.debounce.500ms="user.name"/>

            <x-input label="Nome de Usuário" wire:model.debounce.250ms="user.username"/>

            <div class="col-span-full">
                <x-inputs.password label="Senha" wire:model.defer="password" />
                <p class="text-sm text-gray-500 cursor-pointer" wire:click="random">Gerar senha randomica</p>
            </div>

            <div class="col-span-full">
                <x-inputs.password label="Confirme a Senha" wire:model.defer="password_confirmation" />
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancelar" x-on:click="close"/>
                    <x-button primary label="Criar" wire:click="create"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
