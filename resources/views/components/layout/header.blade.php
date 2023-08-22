<div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
    <button x-on:click="mobile = !mobile" type="button" class="text-gray-700 -m-2.5 p-2.5 lg:hidden">
        <span class="sr-only">Open sidebar</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
        </svg>
    </button>
    <x-button.circle sm primary href="{{ route('frontend') }}">
        <x-heroicon-s-arrow-up-right class="h-6 w-6 text-white" />
    </x-button.circle>
    <div class="flex flex-1 justify-end gap-x-4 self-stretch lg:gap-x-6">
        <div class="flex items-center gap-2">
            @if (session()->has('impersonate'))
                <livewire:impersonate.logout />
            @endif
            <button x-on:click="slide = !slide; $dispatch('notification')" type="button" class="-m-2.5 p-2.5 text-primary-400 hover:text-gray-500 transition">
                <span class="sr-only">View notifications</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
            </button>
            <div class="relative" x-data="{ profile : false }" x-on:click.outside="profile = false">
                <button x-on:click="profile = !profile"
                        type="button"
                        class="flex items-center -m-1.5 p-1.5"
                        id="user-menu-button"
                        aria-expanded="false"
                        aria-haspopup="true"
                >
                    <img class="h-8 w-8 rounded-full bg-gray-50"
                         src="{{ user()->avatar() }}"
                         alt="{{ user()->name }}">
                    <span class="hidden lg:flex lg:items-center">
                        <span class="ml-4 text-sm font-semibold leading-6 text-gray-900 uppercase" aria-hidden="true">{{ user()->name }}</span>
                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd"/>
                        </svg>
                      </span>
                </button>
                <div x-show="profile"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 z-10 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 mt-2.5 focus:outline-none"
                     role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <a href="{{ route('admin.profile.edit') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50" role="menuitem"
                       tabindex="-1"
                       id="user-menu-item-0">Perfil</a>
                    <a href="{{ route('admin.password.edit') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50" role="menuitem"
                       tabindex="-1"
                       id="user-menu-item-0">Senha</a>
                    <a href="{{ route('admin.logout') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50" role="menuitem"
                       tabindex="-1"
                       id="user-menu-item-1">Sair</a>
                </div>
            </div>
        </div>
    </div>
</div>
