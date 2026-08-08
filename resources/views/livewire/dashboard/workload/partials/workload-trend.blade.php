<div class="rounded-xl border border-gray-200 bg-white shadow-sm">

    <div class="p-5">

        <x-chart.basic
            id="workloadTrend"
            title="Workload Harian"
            type="area"
            height="320"
            :categories="$result->workloadTrend['categories']"
            :series="$result->workloadTrend['series']"
        />

    </div>

</div>