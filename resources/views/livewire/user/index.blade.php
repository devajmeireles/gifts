<div>
    @php /** @var \App\Models\User $user */ @endphp
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flow-root">
            <div class="flex justify-end">
                <livewire:user.create />
            </div>
            <x-table.filter quantity search />
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <x-table :items="$users">
                        <x-table.thead>
                            <x-table.tr>
                                <x-table.th column="id" :$sort :$direction first label="#" />
                                <x-table.th column="name" :$sort :$direction label="Nome" />
                                <x-table.th column="username" :$sort :$direction label="Nome de Usuário" />
                                <x-table.th column="role" :$sort :$direction label="Regra" />
                                <x-table.th />
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                            @forelse ($users as $user)
                                <x-table.tr>
                                    <x-table.td class="inline-flex items-center gap-2" first>
                                        <livewire:impersonate.login :user="$user" :key="md5($user->id)" />
                                        {{ $user->id }}
                                    </x-table.td>
                                    <x-table.td>{{ $user->name }}</x-table.td>
                                    <x-table.td>{{ $user->username }}</x-table.td>
                                    <x-table.td>
                                        <livewire:user.role :user="$user" :key="md5('edit-role'.$user->id)" />
                                    </x-table.td>
                                    <x-table.td buttons>
                                        <livewire:user.delete :user="$user" :key="$user->id" />
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty />
                            @endforelse
                        </x-table.tbody>
                    </x-table>
                </div>
            </div>
            <x-pagination :items="$users" />
        </div>
    </div>
</div>
