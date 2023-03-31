<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden border-t border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    {{ $slot }}
                </table>
                {{ $links ?? '' }}
            </div>
        </div>
    </div>
</div>
