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
            <x-button wire:click='setCreate'>
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
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    No
                </th>
                <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                </th>
                <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Kategori
                </th>
                <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Harga
                </th>
                {{-- <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Deskripsi
                </th> --}}
                <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Foto
                </th>
                <th align="end" class="px-6 py-3 text-d text-xs font-medium text-gray-500 uppercase tracking-wider">

                </th>
            </tr>
        </thead>
        <tbody>
            @if ($products->count() == 0)
                <tr class=" bg-white text-center">
                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        Belum Ada Data....
                    </td>
                </tr>
            @else
                @foreach ($products as $product)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} text-center">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $product->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $product->category->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $product->price }}
                        </td>
                        {{-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $product->description }}
                        </td> --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $product->in_stock ? 'Tersedia' : 'Tidak Tersedia' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 justify-center flex">
                            <img src="{{ asset('storage/images/' . $product->image) }}" width="100px" alt="">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">
                            {{-- <a href="#" class="text-blue-600 hover:underline">Edit</a> --}}
                            <div class="flex justify-end gap-2">
                                <x-button wire:click='setEditFoto({{ $product->id }})'>Edit Foto</x-button>
                                <x-button wire:click='setEdit({{ $product->id }})'>Edit</x-button>
                                <x-danger-button wire:click='delete({{ $product->id }})'>Hapus</x-danger-button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    @if ($modalEditFoto)
        <x-modal-create>
            <x-slot name="title">
                Edit Foto
            </x-slot>

            <form wire:submit="updateFoto({{ $id }})">
                <input type="text" hidden wire:model="id">
                <div class="px-6 py-4">
                    <div>
                        <x-label for="image" value="{{ __('Foto') }}" />
                        <input type="file" wire:model.live="image"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                        <x-input-error for="image" class="mt-2" />
                    </div>
                </div>
                <div class="mt-2">
                    @if ($image)
                        <img src="{{ $image instanceof \Illuminate\Http\UploadedFile ? $image->temporaryUrl() : asset('storage/images/' . $product->image) }}"
                            alt="" style="width: 200px">
                    @endif
                </div>
                <div class="flex items-center justify-end mt-4">

                    <x-button class="ms-4" wire:loading.attr="disabled" wire:target="image">
                        {{ __('Simpan') }}
                    </x-button>
                </div>
            </form>
        </x-modal-create>
    @endif

    @if ($modalEdit)
        <x-modal-create>
            <x-slot name="title">
                Edit Produk
            </x-slot>


            <div class="px-6 py-4">
                <form wire:submit='update({{ $id }})'>
                    <input type="text" hidden wire:model="id">
                    <div>
                        <x-label for="name" value="{{ __('Nama Produk') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                            wire:model.live="name" required autofocus />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-label for="category_id" value="{{ __('Harga') }}" />
                        {{-- <x-input id="price" class="block mt-1 w-full" type="number" name="price" wire:model.live="price" required autofocus/> --}}
                        <select
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            name="category_id" id="category_id" wire:model.live="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="category_id" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-label for="price" value="{{ __('Harga (Tidak perlu menggunakan titik koma)') }}" />
                        <x-input id="price" class="block mt-1 w-full" type="number" name="price"
                            wire:model.live="price" required />
                        <x-input-error for="price" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-label for="description" value="{{ __('Deskripsi') }}" />
                        <x-input id="description" class="block mt-1 w-full" type="text" name="description"
                            wire:model.live="description" required />
                        <x-input-error for="description" class="mt-2" />
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
    @if ($modalCreate)
        <x-modal-create>
            <x-slot name="title">
                Edit Produk
            </x-slot>


            <div class="px-6 py-4">
                <form wire:submit='store'>
                    {{-- <input type="text" hidden wire:model="id"> --}}
                    <div>
                        <x-label for="name" value="{{ __('Nama Produk') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                            wire:model.live="name" required autofocus />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-label for="category_id" value="{{ __('Harga') }}" />
                        {{-- <x-input id="price" class="block mt-1 w-full" type="number" name="price" wire:model.live="price" required autofocus/> --}}
                        <select
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            name="category_id" id="category_id" wire:model.live="category_id">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="category_id" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-label for="price" value="{{ __('Harga (Tidak perlu menggunakan titik koma)') }}" />
                        <x-input id="price" class="block mt-1 w-full" type="number" name="price"
                            wire:model.live="price" required />
                        <x-input-error for="price" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-label for="description" value="{{ __('Deskripsi') }}" />
                        <x-input id="description" class="block mt-1 w-full" type="text" name="description"
                            wire:model.live="description" required />
                        <x-input-error for="description" class="mt-2" />
                    </div>
                    <div class="px-6 py-4">
                        <div>
                            <x-label for="image" value="{{ __('Foto') }}" />
                            <input type="file" wire:model.live="image"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                            <x-input-error for="image" class="mt-2" />
                        </div>
                    </div>
                    <div class="mt-2">
                        @if ($image)
                            <img src="{{ $image instanceof \Illuminate\Http\UploadedFile ? $image->temporaryUrl() : asset('storage/images/' . $product->image) }}"
                                alt="" style="width: 200px">
                        @endif
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
