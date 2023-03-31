@props(['color' => 'indigo'])

@php
    $colors = match($color) {
        "red" => "bg-red-600 text-white hover:bg-red-500 focus-visible:outline-red-600",
        "white" => "bg-white text-gray-700 hover:bg-indigo-50 focus-visible:outline-indigo-200",
        default => "bg-indigo-600 text-white hover:bg-indigo-500 focus-visible:outline-indigo-600",
    };
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $colors . ' flex w-full justify-center rounded-md py-2 px-3 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2']) }}>
    {{ $slot }}
</button>
