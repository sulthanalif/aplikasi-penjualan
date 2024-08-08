<div class="min-h-screen">
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 fixed top-0 left-0 right-0 z-50"
        style="top: 0px; left: 0px; right: 0px;">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="/">
                            <img src="{{ asset('logo.png') }}" alt="" style="width: 60px">
                        </a>
                    </div>

                </div>
                <!-- Navigation Links -->
                <div class="hidden flex justify-end items-center space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-button wire:click="openModalCheckOrder">
                        Cek Pesanan
                    </x-button>
                    @if ($noTable)
                        <x-button wire:click="goToCharts">
                            {{ $chart_count }}
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 11-4 0 2 2 0 014 0zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </x-button>
                    @endif
                    @if (auth()->check())
                        <x-button>
                            <a href="{{ route('dashboard') }}" wire:navigate>{{ auth()->user()->name }}</a>
                        </x-button>
                    @endif
                </div>


                <!-- Hamburger -->
                <div class="-me-2 flex items-center gap-4 sm:hidden">
                    <x-button wire:click="openModalCheckOrder">
                        Cek Pesanan
                    </x-button>
                    @if ($noTable)
                        <x-button wire:click="goToCharts">
                            {{ $chart_count }}
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 11-4 0 2 2 0 014 0zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </x-button>
                    @endif
                    @if (auth()->check())
                        <x-button>
                            <a href="{{ route('dashboard') }}" wire:navigate>{{ auth()->user()->name }}</a>
                        </x-button>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8"></div>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 mb-8 ">
        <div class="mt-16 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-50 flex justify-center gap-2">
                <x-button wire:click="resetFilter">All</x-button>
                @foreach ($categories as $category)
                    <x-button class="mr-2" wire:click="filter({{ $category->id }})">{{ $category->name }}</x-button>
                @endforeach
            </div>
            <div class="w-full flex justify-center mt-4">
                <input wire:model.live="search" type="search"
                    class="w-50 pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                    placeholder="Search..." />
            </div>
            <div class="bg-white overflow-hidden px-4 py-4 mb-8 sm:rounded-lg">
                @if (count($products) > 0)
                    <div class="grid grid-cols-1 shadow-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($products as $product)
                            @if ($product->in_stock)
                                <div class="col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-1">
                                    <div class="p-4 border border-gray-200 rounded-lg">
                                        <div class="px-4 py-2 flex justify-between">
                                            <div>
                                                <h2 class="text-lg font-semibold hover:underline">
                                                    <button class=""
                                                        wire:click="openModalShow({{ $product->id }})">{{ $product->name }}</button>
                                                </h2>
                                                <span class="text-sm">{{ $product->category->name }}</span>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Illuminate\Support\Str::limit($product->description, 50, '...') }}
                                                </p>
                                                <p class="text-lg font-semibold">Rp.{{ $product->price }}</p>
                                            </div>
                                            <div class="flex justify-center">
                                                @if ($product->image != null)
                                                    <img src="{{ asset('storage/images/' . $product->image) }}"
                                                        alt="" style="width: 100px">
                                                @else
                                                    <img src="{{ asset('images.jpeg') }}" alt=""
                                                        style="width: 100px">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-4 flex justify-end px-4 py-2">
                                            @if ($noTable)
                                                <x-button wire:click="addToCart({{ $product }})">+</x-button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-4">
                        Tidak ada produk yang tersedia
                    </div>
                @endif
            </div>
        </div>
        {{ $products->links() }}
    </div>

    @if ($modalShow)
        <x-modal-create>
            <x-slot name="title">

            </x-slot>

            {{-- <div class="px-4 py-2 flex justify-between"> --}}
            <div class="flex justify-center">
                @if ($productShow->image != null)
                    <img src="{{ asset('storage/images/' . $productShow->image) }}" alt=""
                        style="width: 200px">
                @else
                    <img src="{{ asset('images.jpeg') }}" alt="" style="width: 200px">
                @endif
            </div>
            <div>
                <h2 class="text-lg font-semibold hover:underline">
                    {{ $productShow->name }}
                </h2>
                <span class="text-sm">{{ $productShow->category->name }}</span>
                <p class="text-sm text-gray-500">
                    {{ $productShow->description }}
                </p>
                <p class="text-lg font-semibold">Rp.{{ $productShow->price }}</p>
            </div>
            {{-- </div> --}}
        </x-modal-create>
    @endif

    @if ($modalCheckOrder)
        <x-modal-create>
            <x-slot name="title">
                List Pesanan
            </x-slot>

            <div>
                <x-label for="no_order" value="{{ __('Nomer Order') }}" />
                <x-input id="no_order" class="block mt-1 w-50" type="text" name="no_order"
                    wire:model.live="no_order" required />
                <x-input-error for="no_order" class="mt-2" />
                @if ($messageCheck)
                    <p class="text-red-500 text-sm">No Order Tidak Ditemukan..</p>
                @endif
            </div>



            <div class="mt-4 flex justify-end">
                <x-button wire:click="checkOrder">Cek</x-button>
            </div>
        </x-modal-create>
    @endif

    @if ($modalInformation)
        <x-modal-create>
            <x-slot name="title">
                Pemberitahuan!
            </x-slot>

            <div>
                <p>Silahkan scan QR code yang tersedia di meja!</p>
            </div>

            <div class="mt-4 flex justify-end">
                <x-danger-button wire:click="closeModal">Tutup</x-danger-button>
            </div>
        </x-modal-create>
    @endif

    @if ($modalChart)
        <x-modal-create>
            <x-slot name="title">
                Keranjang
            </x-slot>

            <div class="w-full">

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
                        @forelse($chart as $index => $cart)
                            <tr>
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $cart['name'] }}</td>
                                <td class="px-6 py-4">{{ $cart['price'] }}</td>
                                <td class="px-6 py-4">
                                    <input type="number" wire:model="chart.{{ $index }}.quantity"
                                        wire:change="calculateTotalPrice"
                                        class="w-20 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                </td>
                                <td class="px-6 py-4">Rp.
                                    {{ number_format($cart['price'] * $cart['quantity'], '0', '.', '.') }}</td>
                                <td class="px-6 py-4">
                                    <x-danger-button size="sm"
                                        wire:click="delete({{ $cart['id'] }})">X</x-danger-button>
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
                            <x-input id="noTable" class="block mt-1 w-50" type="number" name="noTable"
                                wire:model.live="noTable" readonly />
                            <x-input-error for="noTable" class="mt-2" />
                        </div>
                    </div>
                    <div class="w-1/2">
                        <x-label for="note" value="{{ __('Catatan') }}" />
                        <textarea wire:model.live="note" placeholder="Catatan..."
                            class="w-40 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    </div>
                </div>
                @if ($messageOrder)
                    <div class="flex items-center justify-end mt-4"></div>
                    <h2 class="text-lg font-semibold">Pesanan Berhasil!</h2>
                    <h2 class="text-lg font-semibold">No Order : {{ $noOrder }}</h2>
                    <p style="color: red; font-style: italic;">
                        Simpan No Order ini jika ingin cek kembali pesanan
                    </p>
            </div>
    @endif
    <div class="flex items-center justify-end mt-4">
        <x-button class="ms-4" wire:click="storeOrder">
            {{ __('Pesan') }}
        </x-button>
        <x-danger-button class="ms-4" wire:click="closeModal">
            {{ __('Tutup') }}
        </x-danger-button>
    </div>
</div>

</x-modal-create>
@endif
</div>
