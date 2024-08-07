<div {{ $attributes }} x-cloak class="fixed inset-0 flex items-center justify-center z-50">
    <div class="bg-transparent bg-opacity-50 fixed inset-0 backdrop-blur-sm" style="z-index: 49; background-color: rgba(0, 0, 0, 0.5)" @click="create = false" wire:click='closeModal'></div>
    <div class="bg-white w-auto rounded-lg shadow-xl" style="z-index: 50;">
        <div class="overflow-y-auto" style="max-height: calc(100vh - 100px);">
            <!-- Modal content -->
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4">{{ $title }}</h2>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

