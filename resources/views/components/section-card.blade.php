<x-section>
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-8">
            <header class="w-full flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-lg leading-6 font-semibold text-gray-900t">
                        {{ $title }}
                    </h2>
                    @isset($text)
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $text }}
                        </p>
                    @endisset
                </div>
                <div class="flex items-center gap-2">
                    @isset($action)
                        {{ $action }}
                    @endisset
                </div>
            </header>

            {{ $slot }}
        </div>
    </div>
</x-section>
