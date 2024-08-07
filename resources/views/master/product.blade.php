<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kategori dan Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Kategori') }}
            </h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:category-table>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Produk') }}
            </h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:product-table>
            </div>
        </div>
    </div>
</x-app-layout>
