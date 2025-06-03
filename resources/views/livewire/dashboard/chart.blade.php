<div>
    <x-card header="Assinaturas">
        <div class="mt-6"
         x-data="{
            values : [{{ collect($this->chart)->map(fn (int $value) => $value)->join(',') }}],
            labels : [{{ collect($this->chart)->keys()->map(fn (string $date, int $value) => "'$date'")->join(',') }}],
            init() {
                let chart = new ApexCharts(this.$refs.chart, this.options)

                chart.render()

                this.$watch('darkTheme', () => chart.updateOptions(this.options))
                this.$watch('values', () => chart.updateOptions(this.options))
            },
            get options () {
                return {
                    colors: ['#e63f66'],
                    chart: {
                        type: 'line',
                        width: '100%',
                        height: 450,
                        background: this.darkTheme ? '#334155' : '#ffffff',
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
        }">
            <div x-ref="chart"></div>
        </div>
    </x-card>
</div>
