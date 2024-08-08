<div class="w-full overflow-x-auto">
    <x-action-message on="">
        {{ session('status') }}
    </x-action-message>
    <div class="flex items-center justify-between mb-5 px-4 py-2">
        <div>
            @hasrole('admin|cashier')
                <x-button wire:click="openModalCreate">
                    Tambah
                </x-button>
            @endhasrole
        </div>
        <div class="relative flex gap-2 w-64">
            <input wire:model.live="date" type="date"
                class="pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium" />
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
                    Nomer Order
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nama Pelanggan
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nomer Kursi
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Total
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status Pesanan
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status Pembayaran
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($orders->count() == 0)
                <tr class="bg-white text-center">
                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        Belum Ada Data...
                    </td>
                </tr>
            @else
                @foreach ($orders as $order)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} text-center">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $order->no_order }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $order->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $order->table->number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rp.{{ number_format($order->total_price, '0', ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $order->status }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $order->payment_status }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex justify-center gap-2 h-8 text-sm ">

                                <x-button wire:click='check({{ $order }})'>Lihat</x-button>


                                @hasrole('admin|cashier')
                                <x-button wire:click='openModalStatus({{ $order->id }})'>Ubah Status</x-button>
                                @endhasrole

                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>


    @if ($modalStatus)
        <x-modal-create>
            <x-slot name="title">
                Ubah Status
            </x-slot>

            <form wire:submit='updateStatus'>
                <div>
                    <x-label for="status" value="{{ __('Status') }}" />
                    <select wire:model.live="status" id="status"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="Pending">Pending</option>
                        <option value="Success">Success</option>
                        <option value="Failed">Failed</option>
                    </select>
                </div>
                <div class="flex justify-end mt-4">
                    <x-button>
                        Simpan
                    </x-button>
                </div>
            </form>
        </x-modal-create>
    @endif

    @if ($modalCreate)
        <x-modal-create>
            <x-slot name="title">
                List Pesanan
            </x-slot>

            <div class="w-full">
                <div class="mb-4">

                    <select name="product_id" id="product_id" wire:model='product_id' wire:change='addProduct'
                        class="block mt-1 w-50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Tambah Produk --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <table class="table-auto w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Produk
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                            <tr>
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $item['name'] }}</td>
                                <td class="px-6 py-4">{{ $item['price'] }}</td>
                                <td class="px-6 py-4">
                                    <input type="number" wire:model="items.{{ $index }}.quantity"
                                        wire:change="calculateTotalPrice"
                                        class="w-20 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                </td>
                                <td class="px-6 py-4">Rp.
                                    {{ number_format($item['price'] * $item['quantity'], '0', '.', '.') }}</td>
                                <td class="px-6 py-4">
                                    <x-danger-button size="sm"
                                        wire:click="delete({{ $item['id'] }})">X</x-danger-button>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-4">Tidak ada produk yang dipilih</td>
                            </tr>
                        @endforelse
                        <tr class="border-2">
                            <th colspan="4" class="text-end p-4">Total Harga : </th>
                            <th class="text-center p-4">Rp.{{ number_format($totalPrice, '0', '.', '.') }}</th>
                            <th class="text-start p-4"></th>
                        </tr>
                    </tbody>
                </table>
                <div class="flex items-center justify-between ">
                    <div class="w-1/2">
                        <div class="mt-4">
                            <x-label for="orderBy" value="{{ __('Pesanan Atas Nama') }}" />
                            <x-input id="orderBy" class="block mt-1 w-50" type="text" name="orderBy"
                                wire:model.live="orderBy" required />
                            <x-input-error for="orderBy" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-label for="noTable" value="{{ __('Nomor Kursi') }}" />
                            <select name="noTable" id="noTable" wire:model.live='noTable' class="block mt-1 w-50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Nomor Kursi --</option>
                                @foreach ($tables as $table)
                                    <option value="{{ $table->id }}">{{ $table->number }}</option>
                                    @endforeach
                            </select>
                            <x-input-error for="noTable" class="mt-2" />
                        </div>
                    </div>
                    <div class="w-1/2">
                        <x-label for="note" value="{{ __('Catatan') }}" />
                        <textarea wire:model.live="note" placeholder="Catatan..."
                            class="w-40 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4" wire:click="storeOrder">
                        {{ __('Simpan') }}
                    </x-button>
                    <x-danger-button class="ms-4" wire:click="closeModal">
                        {{ __('Tutup') }}
                    </x-danger-button>
                </div>
            </div>

        </x-modal-create>
    @endif
</div>
