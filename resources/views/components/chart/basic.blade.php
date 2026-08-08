@props([
    'id' => 'assetChart',
    'type' => 'area',
    'height' => 350,
    'categories' => [],
    'series' => [],
    'title' => 'Grafik Asset'
])

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">

    <div class="mb-4">

        <h3 class="text-base font-semibold text-gray-800">
            {{ $title }}
        </h3>

    </div>

    <div
        x-data="{
            chart: null,

            init() {

                let chartType = '{{ $type }}';

                let options = {

                    chart: {
                        type: chartType,
                        height: {{ $height }},
                        toolbar: {
                            show: false
                        }
                    },

                    series: @js($series ?? []),

                    colors: [
                        '#158F8A',
                        '#ef4444',
                        '#3b82f6',
                        '#f59e0b',
                        '#8b5cf6',
                    ],

                    dataLabels: {
                        enabled: false
                    },

                    legend: {
                        position: 'top'
                    },

                    grid: {
                        borderColor: '#f1f5f9'
                    },
                };

                /*
                |--------------------------------------------------------------------------
                | TYPE CONFIG
                |--------------------------------------------------------------------------
                */

                if (
                    chartType === 'line' ||
                    chartType === 'bar' ||
                    chartType === 'area'
                ) {

                    options.xaxis = {
                        categories: @js($categories ?? [])
                    };
                }

                /*
                |--------------------------------------------------------------------------
                | DONUT / PIE
                |--------------------------------------------------------------------------
                */

                if (
                    chartType === 'donut' ||
                    chartType === 'pie'
                ) {

                    options.labels = @js($categories ?? []);
                }

                /*
                |--------------------------------------------------------------------------
                | AREA
                |--------------------------------------------------------------------------
                */

                if (chartType === 'area') {

                    options.stroke = {
                        curve: 'smooth',
                        width: 3
                    };

                    options.fill = {
                        type: 'gradient',
                        gradient: {
                            opacityFrom: 0.35,
                            opacityTo: 0.05
                        }
                    };

                    options.markers = {
                        size: 4
                    };
                }

                /*
                |--------------------------------------------------------------------------
                | LINE
                |--------------------------------------------------------------------------
                */

                if (chartType === 'line') {

                    options.stroke = {
                        curve: 'smooth',
                        width: 4
                    };

                    options.markers = {
                        size: 5
                    };
                }

                /*
                |--------------------------------------------------------------------------
                | BAR
                |--------------------------------------------------------------------------
                */

                if (chartType === 'bar') {

                    options.plotOptions = {
                        bar: {
                            borderRadius: 6,
                            columnWidth: '55%'
                        }
                    };
                }

                /*
                |--------------------------------------------------------------------------
                | DONUT
                |--------------------------------------------------------------------------
                */

                if (chartType === 'donut') {

                    options.plotOptions = {
                        pie: {
                            donut: {
                                size: '65%'
                            }
                        }
                    };
                }

                this.chart = new ApexCharts(
                    this.$refs.chartContainer,
                    options
                );

                this.chart.render();
            },
        }"
        class="w-full"
    >

        <div x-ref="chartContainer"></div>

    </div>

</div>