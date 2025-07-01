<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach (['update-profile-information-form', 'update-password-form', 'delete-user-form'] as $partial)
                <div class="p-6 sm:p-8 bg-[#0f0f0f] border border-gray-700 shadow sm:rounded-lg mx-auto max-w-2xl">
                    <div class="max-w-xl">
                        @include('profile.partials.' . $partial)
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
