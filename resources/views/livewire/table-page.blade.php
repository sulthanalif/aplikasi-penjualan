<div class="w-full overflow-x-auto">
    @if (session('status'))
        <div class="alert px-4 py-3 alert-success" x-data="{ shown: false, timeout: null }" x-init="shown = {{ session()->has('status') ? 'true' : 'false' }};
        timeout = setTimeout(() => { shown = false }, 2000)"
            x-show.transition.out.opacity.duration.1500ms="shown" x-transition:leave.opacity.duration.1500ms
            style="display: none;">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-5 px-4 py-2">
        <div>
            <x-button wire:click='openModalCreate'>
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Kode Meja
                </th>
                <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nomer Meja
                </th>
                <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Code QR
                </th>
                <th class="px-6 py-3 text-d text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($tables->count() == 0)
                <tr class=" bg-white text-center">
                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        Belum Ada Data....
                    </td>
                </tr>
            @else
                @foreach ($tables as $table)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} text-center">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $table->code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $table->number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 flex justify-center">
                            @if ($table->qr_code)
                            <img src="{{ asset('storage/' . $table->qr_code)  }}" alt="" style="width: 100px">
                            @else
                                Tidak Ada
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-10 ">
                            {{-- <a href="#" class="text-blue-600 hover:underline">Edit</a> --}}
                            <div class="flex justify-center gap-2 h-10">
                                @if ($table->qr_code == null)
                                <x-button wire:click='generateQR({{ $table->id }})'>Buat QR</x-button>
                                @endif
                                <x-button wire:click='setEdit({{ $table->id }})'>Edit</x-button>
                                <x-danger-button wire:click='delete({{ $table->id }})'>Hapus</x-danger-button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="px-6 py-4">
        {{ $tables->links() }}
    </div>

    @if ($modalCreate)
        <x-modal-create>
            <x-slot name="title">
                Form Meja
            </x-slot>


            <div class="px-6 py-4">
                <form wire:submit='store'>
                    <div>
                        <x-label for="number" value="{{ __('Nomor Meja') }}" />
                        <x-input id="number" class="block mt-1 w-full" type="number" name="number"
                            wire:model.live="number" required autofocus />
                        <x-input-error for="number" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">

                        <x-button class="ms-4">
                            {{ __('Simpan') }}
                        </x-button>
                    </div>
                </form>
            </div>

        </x-modal-create>
    @endif

    @if ($modalEdit)
        <x-modal-create>
            <x-slot name="title">
                Form Meja
            </x-slot>

            <div class="px-6 py-4">
                <form wire:submit='update'>
                    <div>
                        <x-label for="number" value="{{ __('Nomor Meja') }}" />
                        <x-input id="number" class="block mt-1 w-full" type="number" name="number"
                            wire:model.live="number" required autofocus />
                        <x-input-error for="number" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">

                        <x-button class="ms-4">
                            {{ __('Simpan') }}
                        </x-button>
                    </div>
                </form>
            </div>

        </x-modal-create>
    @endif
</div>
