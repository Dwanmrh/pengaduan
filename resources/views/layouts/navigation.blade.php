<nav x-data="{ open: false }" class="bg-[#450000] border-b border-[#5c0000] text-white">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/custom-logo.png') }}" class="block h-9 w-auto" alt="Logo" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-gray-200 font-semibold">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @auth
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'mahasiswa')
                            <x-nav-link :href="route('dosen.index')" :active="request()->routeIs('dosen.index')" class="text-white hover:text-gray-200 font-semibold">
                                {{ __('Dosen') }}
                            </x-nav-link>
                        @endif

                        @if (Auth::user()->role === 'admin')
                            <x-nav-link :href="route('mahasiswa.index')" :active="request()->routeIs('mahasiswa.index')" class="text-white hover:text-gray-200 font-semibold">
                                {{ __('Mahasiswa') }}
                            </x-nav-link>
                        @endif
                    @endauth

                    <x-nav-link :href="route('pengaduan.index')" :active="request()->routeIs('pengaduan.index')" class="text-white hover:text-gray-200 font-semibold">
                        {{ __('Pengaduan') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tanggapan.index')" :active="request()->routeIs('tanggapan.index')" class="text-white hover:text-gray-200 font-semibold">
                        {{ __('Tanggapan') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-white bg-[#450000] hover:text-gray-200 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-gray-800 hover:bg-gray-100">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-800 hover:bg-gray-100">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-200 hover:bg-[#5c0000] focus:outline-none focus:bg-[#5c0000] focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#450000] text-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-gray-200">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dosen.index')" :active="request()->routeIs('dosen')" class="text-white hover:text-gray-200">
                {{ __('Dosen') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('mahasiswa.index')" :active="request()->routeIs('mahasiswa')" class="text-white hover:text-gray-200">
                {{ __('Mahasiswa') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pengaduan.index')" :active="request()->routeIs('pengaduan')" class="text-white hover:text-gray-200">
                {{ __('Pengaduan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tanggapan.index')" :active="request()->routeIs('tanggapan')" class="text-white hover:text-gray-200">
                {{ __('Tanggapan') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[#5c0000]">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:text-gray-200">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();" class="text-white hover:text-gray-200">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
