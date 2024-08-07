<div class="w-full overflow-x-auto" x-data="{ create: false }">
    @if (session('status'))
        <div class="alert px-4 py-3 alert-success" x-data="{ shown: false, timeout: null }" x-init="shown = {{ session()->has('status') ? 'true' : 'false' }};
        timeout = setTimeout(() => { shown = false }, 2000)"
            x-show.transition.out.opacity.duration.1500ms="shown" x-transition:leave.opacity.duration.1500ms
            style="display: none;">
            {{ session('status') }}
        </div>
    @endif
    {{-- <x-action-message on="">
        {{ session('status') }}
    </x-action-message> --}}
    <div class="flex items-center justify-between mb-5 px-4 py-2">
        <div>
            <x-button wire:click='export'>
                Cetak
            </x-button>
        </div>
        <div class="flex justify-end gap-2 w-64">
            <x-button wire:click='clearSearch'>
                Reset
            </x-button>
            <input wire:model.live="search" type="date"
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
                    Tanggal
                </th>
                <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Customer
                </th>
                <th class="px-6 ml-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Total Order
                </th>
            </tr>
        </thead>
        <tbody >
            @if (empty($datas))
                <tr class=" bg-white text-center">
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        Belum Ada Data....
                    </td>
                </tr>
            @else
                @foreach ($datas as $index => $data)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} text-center"
                        >
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $data->customer_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rp. {{ number_format($data->total_payment, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>


</div>

