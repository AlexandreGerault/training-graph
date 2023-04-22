<x-shared::app-layout>
    <x-slot name="header">
        {{ $vm->name }}
    </x-slot>

    <div class="grid lg:px-16 py-8 sm:grid-cols-[minmax(400px,auto),1fr] gap-8">
        <div class="sm:mx-auto sm:w-full flex flex-col gap-8">
            <x-section-card title="Description">
                {{ $vm->description }}
            </x-section-card>

            <x-section-card title="Ajouter une série">
                <form class="flex flex-col gap-4" method="POST"
                      action="{{ route('training.add_metric_record', $vm->uuid) }}">
                    @csrf

                    <div>
                        <x-form.label for="date" :value="__('training.cs_go_aim_reflex_training.metric_records.date')"/>
                        <div class="mt-2">
                            <x-form.input id="date" name="date" type="date" value="{{ now()->format('Y-m-d') }}"
                                          required/>
                        </div>
                    </div>

                    <div>
                        <x-form.label for="targetCount"
                                      :value="__('training.cs_go_aim_reflex_training.metric_records.target_count')"/>
                        <div class="mt-2">
                            <x-form.input id="targetCount" name="values[targetCount]" type="number" required/>
                        </div>
                    </div>

                    <div>
                        <x-form.label for="hitCount"
                                      :value="__('training.cs_go_aim_reflex_training.metric_records.hit_count')"/>
                        <div class="mt-2">
                            <x-form.input id="hitCount" name="values[hitCount]" type="number" required/>
                        </div>
                    </div>

                    <div>
                        <x-form.label for="missCount"
                                      :value="__('training.cs_go_aim_reflex_training.metric_records.miss_count')"/>
                        <div class="mt-2">
                            <x-form.input id="missCount" name="values[missCount]" type="number" required/>
                        </div>
                    </div>

                    <x-button color="indigo">Ajouter</x-button>
                </form>
            </x-section-card>
        </div>

        <div class="sm:mx-auto sm:w-full">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <h3 class="font-bold">Graphique</h3>

                @include('training.charts.cs_go_aim_reflex_training', ['chartData' => $vm->graphData])
            </div>
        </div>
    </div>

    <div class="grid lg:px-16 py-8">
        <x-section-card-table>
            <x-slot name="title">
                <h3 class="font-bold">Dernières séries</h3>
            </x-slot>

            <x-table>
                <x-table.head>
                    <x-table.row>
                        @foreach($vm->metricColumns as $column)
                            <x-table.heading-cell>
                                {{ __('training.cs_go_aim_reflex_training.metric_records.' . $column) }}
                            </x-table.heading-cell>
                        @endforeach
                    </x-table.row>
                </x-table.head>
                <x-table.body>
                    @foreach($vm->metricRecords as $metricRecord)
                        <x-table.row>
                            <x-table.cell>
                                {{ $metricRecord->date()->format('d/m/Y') }}
                            </x-table.cell>
                            @foreach($metricRecord as $key => $value)
                                <x-table.cell>
                                    {{$value}}
                                </x-table.cell>
                            @endforeach
                        </x-table.row>
                    @endforeach
                </x-table.body>
            </x-table>
        </x-section-card-table>
    </div>
</x-shared::app-layout>
