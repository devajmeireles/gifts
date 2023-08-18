<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-3 gap-4">
        <livewire:dashboard.card :type="\App\Enums\Dashboard\CardType::AllItems" />
        <livewire:dashboard.card :type="\App\Enums\Dashboard\CardType::ItemsSigned" />
        <livewire:dashboard.card :type="\App\Enums\Dashboard\CardType::ItemsNotSigned" />
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
