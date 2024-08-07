<div class="grid grid-cols-2 gap-4 px-4 py-2">
    <div class="bg-gray-200 rounded-lg p-4">
        <h2 class="text-center text-lg font-semibold">Total Pemasukan</h2>
        <p class="mt-2 text-center text-gray-500">
            Rp. {{ number_format($income, '0', '.', '.') }}
        </p>
    </div>
    <div class="bg-gray-200 rounded-lg p-4">
        <h2 class="text-center text-lg font-semibold">Total Pesanan</h2>
        <p class="mt-2 text-center text-gray-500">
            {{ $order }}
        </p>
    </div>
    <div class="bg-gray-200 rounded-lg p-4">
        <h2 class="text-center text-lg font-semibold">Total Pesanan Sudah Bayar</h2>
        <p class="mt-2 text-center text-gray-500">
            {{ $orderPaid }}
        </p>
    </div>
    <div class="bg-gray-200 rounded-lg p-4">
        <h2 class="text-center text-lg font-semibold">Total Pesanan Belum Bayar</h2>
        <p class="mt-2 text-center text-gray-500">
            {{ $orderUnpaid }}
        </p>
    </div>
</div>

