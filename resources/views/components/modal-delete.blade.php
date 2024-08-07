<div x-show="isDelete" x-cloak class="fixed inset-0 flex items-center justify-center z-50">
    <div class="bg-transparent bg-opacity-50 fixed inset-0 backdrop-blur-sm" style="z-index: 49; background-color: rgba(0, 0, 0, 0.5)"></div>
    <div class="bg-white rounded-lg p-6 shadow-xl" style="z-index: 50;">
        <!-- Modal content -->
        <div>
            <h2 class="text-2xl font-semibold mb-4">{{ $title }}</h2>
            {{ $slot }}
        </div>
    </div>
</div>

