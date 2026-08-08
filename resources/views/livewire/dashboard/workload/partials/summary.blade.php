{{-- Summary --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

    {{-- Total Workload --}}
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Total Workload
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $this->formatDuration($result->totalWorkloadMinutes) }}
                </p>

                <p class="mt-2 text-xs text-gray-500">
                    Work Session + Aktivitas Spontan
                </p>

            </div>

        </div>

    </div>

</div>