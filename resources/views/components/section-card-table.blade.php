<x-section>
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white">
            <header class="w-full flex justify-between items-start py-6 px-4 sm:p-6">
                <div>
                    <h2 class="text-lg leading-6 font-medium text-gray-900t">
                        {{ $title }}
                    </h2>
                    @isset($text)
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $text }}
                        </p>
                    @endisset
                </div>
                <div class="flex gap-2">
                    @isset($action)
                        {{ $action }}
                    @endisset
                </div>
            </header>

            {{ $slot }}
        </div>
    </div>
</x-section>
