<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-1">
            <x-card>
                <div class="ml-4 p-2">
                    <div class="flex items-center justify-start">
                        <div class="flex-shrink-0">
                            <p class="text-3xl text-primary font-semibold">123</p>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">
                                Itens Cadastrados
                            </h3>
                            <x-badge outline primary>
                                80% em Fraldas
                            </x-badge>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-span-1">
            <x-card>
                <div class="ml-4 p-2">
                    <div class="flex items-center justify-start">
                        <div class="flex-shrink-0">
                            <p class="text-3xl text-primary font-semibold">22</p>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">
                                Itens Assinados
                            </h3>
                            <x-badge outline primary>
                                22% em Utensilhos
                            </x-badge>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-span-1">
            <x-card>
                <div class="ml-4 p-2">
                    <div class="flex items-center justify-start">
                        <div class="flex-shrink-0">
                            <p class="text-3xl text-primary font-semibold">123</p>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">
                                Itens Restantes
                            </h3>
                            <x-badge outline primary>
                                50% em Roupas
                            </x-badge>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <div class="mt-6"
         x-data="{
            values : [{{ collect($dates)->keys()->map(fn($date) => $date)->join(',') }}],
            labels : [{{ collect($dates)->keys()->map(fn($date) => $date)->join(',') }}],
            async init() {
                let chart = new ApexCharts(this.$refs.chart, this.options)

                await chart.render()

                this.$watch('values', () => {
                    chart.updateOptions(this.options).then(r => {})
                })
            },
            get options () {
                return {
                    chart: { type: 'line', width: '100%', height: 450, background: this.dark ? '#4B5563' : '#ffffff', foreColor: this.dark ? '#ffffff' : '#4b5563',
                        toolbar: {
                            show: false
                        }
                    },
                    tooltip: {
                        marker: false,
                        y: {
                            formatter(number) {
                                return number
                            }
                        },
                        theme: 'light'
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    xaxis: { categories: this.labels },
                    series: [{
                        name: 'A',
                        data: this.values,
                    }],
                }
            }
        }">
        <x-card>
            <div x-ref="chart"></div>
        </x-card>
    </div>
</x-app-layout>
