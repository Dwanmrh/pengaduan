<section>
    <header class="mb-4">
        <h2 class="text-lg font-medium text-white">{{ __('Profile Information') }}</h2>
        <p class="mt-1 text-sm text-gray-300">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-white">Name</label>
            <input id="name" name="name" type="text"
                class="mt-1 block w-full rounded-md border border-gray-600 bg-[#0f0f0f] text-white shadow-sm focus:border-[#C5B358] focus:ring-[#C5B358] sm:text-sm"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-white">Email</label>
            <input id="email" name="email" type="email"
                class="mt-1 block w-full rounded-md border border-gray-600 bg-[#0f0f0f] text-white shadow-sm focus:border-[#C5B358] focus:ring-[#C5B358] sm:text-sm"
                value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-gray-400">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" class="underline text-sm text-[#C5B358] hover:text-yellow-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </div>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm text-green-500">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-[#C5B358] text-black font-semibold text-sm rounded-md shadow hover:bg-yellow-600 transition">
                {{ __('Save') }}
            </button>
            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-500">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <form method="post" action="{{ route('verification.send') }}" id="send-verification">
        @csrf
    </form>
</section>
