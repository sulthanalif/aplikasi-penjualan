<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="font-semibold">No Pesanan:</p>
                <p class="text-gray-500">{{ $order->no_order }}</p>
            </div>
            <div>
                <p class="font-semibold">Nama Pemesan:</p>
                <p class="text-gray-500">{{ $order->name }}</p>
            </div>
            <div>
                <p class="font-semibold">No Meja:</p>
                <p class="text-gray-500">{{ $order->no_table }}</p>
            </div>
            <div>
                <p class="font-semibold">Total Harga:</p>
                <p class="text-gray-500">Rp.{{ number_format($order->total_price, '0', ',', '.') }}</p>
            </div>
            <div>
                <p class="font-semibold">Status Pesanan:</p>
                <p class="text-gray-500">{{ $order->status }}</p>
            </div>
            <div>
                <p class="font-semibold">Status Pembayaran:</p>
                <p class="text-gray-500">{{ $order->payment_status }}</p>
            </div>
        </div>
        <div class="mt-5">
            <h2 class="font-semibold mb-2">Daftar Pesanan</h2>
            <table class="w-full table-auto text-sm">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">Nama Menu</th>
                        <th class="border px-4 py-2">Harga</th>
                        <th class="border px-4 py-2">Jumlah</th>
                        <th class="border px-4 py-2">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderList as $detail)
                        <tr>
                            <td class="border text-center px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $detail->product->name }}</td>
                            <td class="border px-4 py-2">Rp.{{ number_format($detail->product->price, '0', ',', '.') }}
                            </td>
                            <td class="border text-center px-4 py-2">{{ $detail->quantity }}</td>
                            <td class="border px-4 py-2">Rp.{{ number_format($detail->total, '0', ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-5 flex justify-end gap-2">
            <x-button >
                <a target="_blank" href="{{ route('invoice', $order) }}">Cetak Invoice</a>
            </x-button>
            @if ($buttonPayment)
                <x-button wire:click='openModalPayment'>Bayar</x-button>
            @endif


            <x-button wire:click='openModalEdit'>Edit</x-button>
            <x-danger-button wire:click='back' wire:navigate>Kembali</x-danger-button>
        </div>
    </div>


    @if ($modalPayment)
        <x-modal-create>
            <x-slot name="title">
                Bayar
            </x-slot>

            <form wire:submit='processPayment'>
                <div>
                    <x-label for="method" value="{{ __('Pilih Metode') }}" />
                    <select wire:model.live="method" id="method"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Pilih Metode --</option>
                        <option value="tunai">Tunai</option>
                        <option value="paymentGateway">Payment Gateway</option>
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

    @if ($modalEdit)
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
                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4" wire:click="updateOrder">
                        {{ __('Simpan') }}
                    </x-button>
                    <x-danger-button class="ms-4" wire:click="closeModal">
                        {{ __('Tutup') }}
                    </x-danger-button>
                </div>
            </div>

        </x-modal-create>
    @endif

    @if ($snap_token != '')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
        </script>

        <script type="text/javascript">
            // SnapToken acquired from previous step
            snap.pay('{{ $snap_token }}', {
                // Optional
                onSuccess: function(result) {

                    // Handle transaction success
                    window.location.href = "{{ route('success', ['order' => $order->id]) }}";
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        </script>
    @endif
</div>
