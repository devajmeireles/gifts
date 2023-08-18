<div class="mt-6"
     x-data="{
            values : [{{ collect($this->chart)->map(fn (int $value) => $value)->join(',') }}],
            labels : [{{ collect($this->chart)->keys()->map(fn (string $date, int $value) => "'$date'")->join(',') }}],
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
        }" wire:init="load">
    <x-card>
        <div class="flex items-center justify-center">
            <div wire:loading class="bg-white bg-opacity-75" aria-hidden="true">
                <div class="flex h-full items-center justify-center">
                    <svg class="h-12 w-12 animate-spin text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div wire:loading.remove x-ref="chart"></div>
    </x-card>
</div>
