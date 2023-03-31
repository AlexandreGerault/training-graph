@props(['color' => 'indigo'])

@php
    $colors = match($color) {
        "red" => "text-white hover:text-white bg-red-800 hover:bg-red-700 focus:border-red-900 ring-red-300 active:bg-red-900",
        default => "text-white hover:text-white bg-indigo-800 hover:bg-indigo-700 focus:border-indigo-900 ring-indigo-300 active:bg-indigo-900",
    };
@endphp

<a {{ $attributes->has('href') ? "href={$attributes->get('href')}" : "" }} {{$attributes->has('title') ? "title={$attributes->get('title')}" : ""}} {{ $attributes->merge(['class' => $colors . " inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25 transition ease-in-out duration-150 cursor-pointer"]) }}>
    {{ $slot }}
</a>
