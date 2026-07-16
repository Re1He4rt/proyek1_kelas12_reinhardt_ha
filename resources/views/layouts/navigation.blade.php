 <div class="flex justify-between items-center h-16">

                            <!-- LOGO -->
                    <div class="flex items-center">

                        <a href="{{ route('home') }}"
                        class="velorix-logo text-decoration-none">

                            <span class="logo-main">
                                VELO
                            </span>

                            <span class="logo-accent">
                                RIX
                            </span>

                        </a>

                    </div>

            <!-- DESKTOP MENU -->
            <div class="hidden lg:flex items-center gap-8">

                <a href="{{ route('home') }}"
                   class="text-gray-700 hover:text-green-600 font-medium transition text-decoration-none">
                    Home
                </a>

                @auth

                    <a href="{{ route('customer.shop.index') }}"
                       class="text-gray-700 hover:text-green-600 font-medium transition text-decoration-none">
                        Belanja
                    </a>

                    <a href="{{ route('customer.cart.index') }}"
                       class="text-gray-700 hover:text-green-600 font-medium transition text-decoration-none">
                        Keranjang
                    </a>

                    <a href="{{ route('customer.orders.index') }}"
                       class="text-gray-700 hover:text-green-600 font-medium transition text-decoration-none">
                        Pesanan Saya
                    </a>

                    <a href="{{ route('customer.profile.index') }}"
                       class="text-gray-700 hover:text-green-600 font-medium transition text-decoration-none">
                        Profil
                    </a>

                @endauth

            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden lg:flex items-center gap-3">

                @guest

                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition text-decoration-none">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-4 py-2 rounded-xl bg-green-500 text-white hover:bg-green-600 transition text-decoration-none shadow-sm">
                        Register
                    </a>

                @else

                    <div class="text-end me-2">
                        <p class="text-sm font-semibold text-gray-800 m-0">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs text-gray-500 m-0">
                            Customer
                        </p>
                    </div>

                    <form method="POST"
                          action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="px-4 py-2 rounded-xl bg-red-500 text-white hover:bg-red-600 transition shadow-sm border-0">
                            Logout
                        </button>
                    </form>

                @endguest

            </div>

            <!-- MOBILE BUTTON -->
            <div class="lg:hidden">

                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">

                    <svg class="h-6 w-6"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">

                        <path
                            :class="{'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path
                            :class="{'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>

        </div>

    </div>

    <!-- MOBILE MENU -->
    <div x-show="open"
         x-transition
         class="lg:hidden bg-white border-t">

        <div class="px-4 py-4 space-y-3">

            <a href="{{ route('home') }}"
               class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 text-decoration-none">
                Home
            </a>

            @auth

                <a href="{{ route('customer.shop.index') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 text-decoration-none">
                    Belanja
                </a>

                <a href="{{ route('customer.cart.index') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 text-decoration-none">
                    Keranjang
                </a>

                <a href="{{ route('customer.orders.index') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 text-decoration-none">
                    Pesanan Saya
                </a>

                <a href="{{ route('customer.profile.index') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 text-decoration-none">
                    Profil
                </a>

                <div class="border-t pt-3">

                    <div class="px-3 mb-3">
                        <p class="font-semibold text-gray-800 m-0">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Customer
                        </p>
                    </div>

                    <form method="POST"
                          action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="w-full text-start px-3 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition border-0">
                            Logout
                        </button>
                    </form>

                </div>

            @else

                <a href="{{ route('login') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 text-decoration-none">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="block px-3 py-2 rounded-lg bg-green-500 text-white hover:bg-green-600 text-decoration-none">
                    Register
                </a>

            @endauth

        </div>

    </div>

</nav>