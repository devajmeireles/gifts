<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Assinaturas
        </h2>
    </x-slot>

    <div class="mb-4">
        <x-input type="text" placeholder="Pesquisar..." class="w-full" />
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-1">
            <x-card>
                <div class="ml-4 p-2">
                    <div class="flex items-center justify-start">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full"
                                 src="https://ui-avatars.com/api/?name=Tom%Cook&background=0D8ABC&color=fff" alt="">
                        </div>
                        <div class="ml-4">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Tom Cook</h3>
                            <p class="text-sm text-gray-500">
                                <a href="#">(71) 91234-4567</a>
                            </p>
                            <p class="text-sm text-gray-500">
                                Assinado: 10/10/2020
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-1">
                    <x-button.circle xs primary icon="pencil" />
                    <x-button.circle xs red icon="trash" />
                </div>
            </x-card>
        </div>
        <div class="col-span-1">
            <x-card>
                <div class="ml-4 p-2">
                    <div class="flex items-center justify-start">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full"
                                 src="https://ui-avatars.com/api/?name=Tom%Cook&background=0D8ABC&color=fff" alt="">
                        </div>
                        <div class="ml-4">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Tom Cook</h3>
                            <p class="text-sm text-gray-500">
                                <a href="#">(71) 91234-4567</a>
                            </p>
                            <p class="text-sm text-gray-500">
                                Assinado: 10/10/2020
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-1">
                    <x-button.circle xs primary icon="pencil" />
                    <x-button.circle xs red icon="trash" />
                </div>
            </x-card>
        </div>
        <div class="col-span-1">
            <x-card>
                <div class="ml-4 p-2">
                    <div class="flex items-center justify-start">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full"
                                 src="https://ui-avatars.com/api/?name=Tom%Cook&background=0D8ABC&color=fff" alt="">
                        </div>
                        <div class="ml-4">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Tom Cook</h3>
                            <p class="text-sm text-gray-500">
                                <a href="#">(71) 91234-4567</a>
                            </p>
                            <p class="text-sm text-gray-500">
                                Assinado: 10/10/2020
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-1">
                    <x-button.circle xs primary icon="pencil" />
                    <x-button.circle xs red icon="trash" />
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
