<section class="space-y-6 mt-10">
    <header class="mb-4">
        <h2 class="text-lg font-medium text-white">{{ __('Delete Account') }}</h2>
        <p class="mt-1 text-sm text-gray-300">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        class="bg-[#7c1c1c] hover:bg-[#a30000] text-white"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-[#1a0000] rounded-lg">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-300">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-[#0f0f0f] text-white border border-gray-600 focus:border-[#C5B358] focus:ring-[#C5B358]"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="mr-3 bg-gray-600 hover:bg-gray-500 text-white">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="bg-[#7c1c1c] hover:bg-[#a30000] text-white">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
