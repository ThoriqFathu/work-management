<div class="rounded-xl border border-gray-200 bg-white shadow-sm">

    <div class="p-5">

        <x-chart.basic
            id="workloadSource"
            title="Sumber Workload"
            type="donut"
            height="320"
            :categories="$result->workloadSource['categories']"
            :series="$result->workloadSource['series'][0]['data']"
        />

    </div>

</div>