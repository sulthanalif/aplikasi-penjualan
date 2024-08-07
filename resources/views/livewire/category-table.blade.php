<div class="w-full overflow-x-auto" x-data="{ create: false }">
    @if (session('status'))
        <div class="alert px-4 py-3 alert-success" x-data="{ shown: false, timeout: null }" x-init="shown = {{ session()->has('status') ? 'true' : 'false' }};
        timeout = setTimeout(() => { shown = false }, 2000)"
            x-show.transition.out.opacity.duration.1500ms="shown" x-transition:leave.opacity.duration.1500ms
            style="display: none;">
            {{ session('status') }}
        </div>
    @endif
    <x-action-message on="">
        {{ session('status') }}
    </x-action-message>
    <div class="flex items-center justify-between mb-5 px-4 py-2">
        <div>
            <x-button @click="create = true">
                Tambah
            </x-button>
        </div>
        <div class="relative w-64">
            <input wire:model.live="search" type="search"
                class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                placeholder="Search..." />
        </div>
    </div>
    <table class="table-auto w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    No
                </th>
                <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                </th>
                <th align="end" class="px-6 py-3 text-d text-xs font-medium text-gray-500 uppercase tracking-wider">

                </th>
            </tr>
        </thead>
        <tbody >
            @if ($categories->count() == 0)
                <tr class=" bg-white text-center">
                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        Belum Ada Data....
                    </td>
                </tr>
            @else
                @foreach ($categories as $category)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} text-center"

                        >
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $category->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">
                            {{-- <a href="#" class="text-blue-600 hover:underline">Edit</a> --}}
                            <div class="flex justify-end gap-2">
                                <x-button wire:click='setEdit({{ $category->id }})' @Click="create = true">Edit</x-button>
                                <x-danger-button wire:click='delete({{ $category->id }})'>Hapus</x-danger-button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="px-6 py-4">
        {{ $categories->links() }}
    </div>

    <x-modal-create x-show="create">
        <x-slot name="title">
            Form Kategori
        </x-slot>


        <div class="px-6 py-4">
            <form wire:submit='store'>
                <input type="text" hidden wire:model="id">
                <div>
                    <x-label for="name" value="{{ __('Nama Kategori') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" wire:model.live="name" required autofocus/>
                    <x-input-error for="name" class="mt-2"/>
                </div>

                <div class="flex items-center justify-end mt-4">

                    <x-button  class="ms-4" @Click="create = false">
                        {{ __('Simpan') }}
                    </x-button>
                </div>
            </form>
        </div>

    </x-modal-create>
</div>
