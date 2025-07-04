<section class="mt-8">
    <header class="mb-4">
        <h2 class="text-lg font-medium text-white">{{ __('Update Password') }}</h2>
        <p class="mt-1 text-sm text-gray-300">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="current_password" :value="__('Current Password')" class="text-white" />
            <x-text-input id="current_password" name="current_password" type="password"
                class="mt-1 block w-full bg-[#0f0f0f] text-white border border-gray-600 focus:border-[#C5B358] focus:ring-[#C5B358]"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="password" :value="__('New Password')" class="text-white" />
            <x-text-input id="password" name="password" type="password"
                class="mt-1 block w-full bg-[#0f0f0f] text-white border border-gray-600 focus:border-[#C5B358] focus:ring-[#C5B358]"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full bg-[#0f0f0f] text-white border border-gray-600 focus:border-[#C5B358] focus:ring-[#C5B358]"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-[#C5B358] text-black hover:bg-yellow-600">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-500">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
