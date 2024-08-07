<div class="w-full overflow-x-auto">
    <x-action-message on="">
        {{ session('status') }}
    </x-action-message>
    <div class="flex items-center justify-between mb-5 px-4 py-2">
        <div>
            <x-button >
                <a href="{{ route('users.create') }}" >Tambah</a>
            </x-button>
        </div>
        <div class="relative w-64">
            <input wire:model.live="search" type="search" class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Search..." />
        </div>
    </div>
    <table class="table-auto w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    No
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Email
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Roles
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} text-center">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @foreach ($user->roles as $role)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{-- <a href="#" class="text-blue-600 hover:underline">Edit</a> --}}
                        <x-danger-button wire:click='delete({{ $user }})'>Hapus</x-danger-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
