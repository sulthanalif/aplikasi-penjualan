<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <form wire:submit='store'>
        <div>
            <x-label for="name" value="{{ __('Nama') }}" />
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" wire:model="name" required autofocus  />
            <x-input-error for="name" class="mt-2" />
        </div>
        <div>
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" wire:model="email" required />
            <x-input-error for="email" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-label for="password" value="{{ __('Password') }}" />
            <x-input id="password" wire:model="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error for="password" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-label for="password2" value="{{ __('Konfirmasi Password') }}" />
            <x-input id="password2" wire:model="password2" class="block mt-1 w-full" type="password" name="password2" required />
            <x-input-error for="password2" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-label for="role" value="{{ __('Role') }}" />
            {{-- <x-input id="password2" wire:model="password2" class="block mt-1 w-full" type="password" name="password2" required /> --}}
            <select name="role" wire:model="role" id="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="admin">Admin</option>
                <option value="cashier">Kasir</option>
                <option value="owner">Pemilik</option>
            </select>
            <x-input-error for="role" class="mt-2" />
        </div>



        <div class="flex items-center justify-end mt-4">

            <x-button class="ms-4">
                {{ __('Simpan') }}
            </x-button>
        </div>
    </form>
</div>
