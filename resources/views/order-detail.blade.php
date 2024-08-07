<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <livewire:order-detail id="{{ $order->id }}" />
    </div>
</x-app-layout>


