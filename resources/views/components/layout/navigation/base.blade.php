<div class="mt-16 flex h-16 shrink-0 items-center">
    <nav class="flex h-16 flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    <x-layout.navigation.link :route="route('admin.dashboard')"
                                              icon="home"
                                              :active="request()->routeIs('admin.dashboard')"
                                              label="Página Inicial"
                    />
                    <x-layout.navigation.link :route="route('admin.items.index')"
                                              icon="gift"
                                              :active="request()->routeIs('admin.items.index')"
                                              label="Itens"
                    />
                    <x-layout.navigation.link :route="route('admin.categories')"
                                              icon="tag"
                                              :active="request()->routeIs('admin.categories')"
                                              label="Categorias"
                    />
                    <x-layout.navigation.link :route="route('admin.signatures.index')"
                                              icon="pencil"
                                              :active="request()->routeIs('admin.signatures.index')"
                                              label="Assinaturas"
                    />
                </ul>
            </li>
            @if (!user()->isGuest())
                <li>
                    <div class="text-xs font-semibold leading-6 text-primary-400">{{ __('Administração') }}</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <ul role="list" class="-mx-2 space-y-1">
                            @if (user()->isAdmin())
                                <x-layout.navigation.link :route="route('admin.users')"
                                                          icon="users"
                                                          :active="request()->routeIs('admin.users')"
                                                          label="Usuários"
                                />
                            @endif
                            <x-layout.navigation.link :route="route('admin.settings')"
                                                      icon="cog"
                                                      :active="request()->routeIs('admin.settings')"
                                                      label="Configurações"
                            />
                        </ul>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
</div>
