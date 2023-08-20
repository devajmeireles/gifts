<div>
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
                    colors: ['#e63f66'],
                    chart: {
                        type: 'line',
                        width: '100%',
                        height: 450,
                        background: '#fff',
                        foreColor: '#e63f66',
                        colors: '#e63f66',
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
                        name: 'Assinaturas',
                        data: this.values
                    }]
                }
            }
        }" wire:init="load">
        <x-card wire:loading>
            <x-preloader />
        </x-card>
        <x-card wire:loading.remove>
            <p class="text-xl text-primary font-semibold">Assinaturas</p>
            <div x-ref="chart"></div>
        </x-card>
    </div>
</div>
