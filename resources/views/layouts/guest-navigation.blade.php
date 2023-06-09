<header class="bg-white" x-data="{ open: false }">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <a href="/" class="-m-1.5 p-1.5">
            <span class="sr-only">Training-Graph</span>
            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
        </a>
        <div class="flex lg:hidden">
            <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                    @click="open = !open" aria-controls="mobile-menu" aria-expanded="false" :aria-expanded="open.toString()"
            >
                <span class="sr-only">Open main menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
            @guest
                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900">
                    {{ __('auth.login') }} <span aria-hidden="true">&rarr;</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold leading-6 text-gray-900">
                    {{ __('Dashboard') }} <span aria-hidden="true">&rarr;</span>
                </a>
            @endguest
        </div>
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class="lg:hidden" role="dialog" aria-modal="true"
         x-cloak
         x-show="open"
         x-on:keydown.escape="open = false"
    >
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 z-10"></div>
        <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Training-Graph</span>
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
                </a>
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700"
                        @click="open = false" aria-controls="mobile-menu" aria-expanded="false" :aria-expanded="open.toString()"
                >
                    <span class="sr-only">Close menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="py-6">
                        @guest
                            <a href="{{ route('login') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                {{ __('auth.login') }}
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('training.list') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                {{ __('Trainings') }}
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
