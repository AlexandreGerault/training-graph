<x-shared::app-layout>
    <x-slot name="header">
        {{ __('training.create.title') }}
    </x-slot>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="flex flex-col gap-4" action="{{ route('training.store') }}" method="POST">
                <x-form.form-errors :errors="$errors" />
                @csrf
                {{  __('training.create.failed_to_save') }}

                <div>
                    <x-form.label for="name" :value="__('name')" />
                    <div class="mt-2">
                        <x-form.input id="name" name="name" type="text" autocomplete="name" required />
                    </div>
                </div>

                <div>
                    <x-form.label for="description" :value="__('description')" />
                    <div class="mt-2">
                        <x-form.input id="description" name="description" type="text" required />
                    </div>
                </div>

                <div>
                    <x-form.label for="trainingType" :value="__('trainingType')" />
                    <div class="mt-2">
                        <x-form.select id="trainingType" name="trainingType">
                            <option value="cs_go_aim_reflex_training">CS:GO - Aim training</option>
                        </x-form.select>
                    </div>
                </div>

                <x-button color="indigo">Créer</x-button>
            </form>
        </div>
    </div>
</x-shared::app-layout>
