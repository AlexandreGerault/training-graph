@props(['label' => 'Sélectionner un fichier', 'name' => 'pdf', 'extensions' => ['application/pdf']])

<label x-data="{ files: null}">
    <div class="flex items-center gap-2">
        <x-button-link>
            {{ $label }}
        </x-button-link>
        <span x-text="files && files.map(file => file.name).join(', ')"></span>
    </div>
    <input type="file"
           name="{{ $name }}"
           class="hidden"
           x-on:change="files = Object.values($event.target.files)"
           @if ($extensions)
               accept="{{ implode(',', $extensions) }}"
        @endif
    />
</label>
