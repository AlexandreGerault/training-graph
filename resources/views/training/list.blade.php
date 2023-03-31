<x-shared::app-layout>
    <x-slot name="header">
        {{ __('training.list.title') }}
    </x-slot>

    <x-slot name="action">
        <x-button-link :href="route('training.create')">
            {{ __('training.create.cta') }}
        </x-button-link>
    </x-slot>

    <section class="max-w-7xl mx-auto flex gap-4 mt-12">
        @foreach($vm->getTrainings() as $training)
            <article class="rounded-lg shadow px-6 py-4 bg-white space-y-2">
                <h1 class="font-bold">
                    <a href="{{ route('training.show', $training->uuid) }}">{{ $training->name }}</a>
                </h1>
                <p>{{ $training->description }}</p>
            </article>
        @endforeach
    </section>
</x-shared::app-layout>
