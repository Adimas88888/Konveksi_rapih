<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus autocomplete="name" required  />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        
        <!-- Telephone -->
        <div class="mt-4">
            <x-input-label for="tlp" :value="__('Telephone')" />
            <x-text-input id="tlp" class="block mt-1 w-full" type="number" name="tlp" :value="old('tlp')" required autofocus autocomplete="tlp" />
            <x-input-error :messages="$errors->get('tlp')" class="mt-2" />
        </div>
        
        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="alamat" :value="__('Address')" />
            <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" required autofocus autocomplete="alamat" />
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>
        
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" pattern=".{8,}" title="Minimum 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        
        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" pattern=".{8,}" title="Minimum 8 characters" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        
        <!-- Photo -->
        <div class="mt-4">
            <x-input-label for="foto" :value="__('Photo')" />
            <x-text-input id="inputFoto" class="block mt-1 w-full" accept=".png, .jpg, .jpeg" type="file" name="foto" :value="old('foto')" required autofocus autocomplete="foto" />
            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
        </div>
        

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
