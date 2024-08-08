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
                {{-- <div class="hidden flex justify-end items-center space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-button wire:click="goToCharts">
                        Cek Pesanan
                    </x-button>
                    <x-button wire:click="goToCharts">
                        {{ $chart_count }}
                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 11-4 0 2 2 0 014 0zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </x-button>
                </div> --}}


                <!-- Hamburger -->
                {{-- <div class="-me-2 flex items-center sm:hidden">
                    <x-button wire:click="goToCharts">
                        {{ $chart_count }}
                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 11-4 0 2 2 0 014 0zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </x-button>
                </div> --}}
            </div>
        </div>
    </nav>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8"></div>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 mb-8 ">
        <div class="mt-16 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden px-4 py-4 mb-8 sm:rounded-lg">
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
                        <p class="text-gray-500">{{ $order->table->number }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Catatan:</p>
                        <p class="text-gray-500">{{ $order->note }}</p>
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
                                    <td class="border text-center px-4 py-2">Rp.{{ number_format($detail->total, '0', ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="border text-end p-4"></th>
                                <th class="border px-4 py-2">Rp.{{ number_format($order->orderList->sum('total'), '0', '.', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-5 flex justify-center">
            <x-danger-button wire:click="back">Kembali</x-danger-button>
        </div>
    </div>
</div>
