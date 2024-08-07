<div {{ $attributes }} x-cloak class="fixed w-50 inset-0 flex items-center justify-center z-50">
    <div class="bg-transparent bg-opacity-50 fixed inset-0 backdrop-blur-sm" style="z-index: 49; background-color: rgba(0, 0, 0, 0.5)" @Click="edit = false" ></div>
    <div class="bg-white w-auto rounded-lg p-6 shadow-xl " style="z-index: 50;">
        <!-- Modal content -->
        <div class="">
            <h2 class="text-2xl font-semibold mb-4">{{ $title }}</h2>
            {{ $slot }}
        </div>
    </div>
</div>

