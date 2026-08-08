{{-- Workload By Type --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm">

    <div class="p-5">

        {{-- Header --}}
        <div>
            <h2 class="font-semibold text-gray-900">
                Beban Kerja Berdasarkan Jenis
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Distribusi waktu berdasarkan jenis aktivitas yang tercatat.
            </p>
        </div>


        @php
            $totalActivityMinutes = collect($result->workloadByType)
                ->sum('durasi_menit');
        @endphp


        {{-- Empty --}}
        @if (empty($result->workloadByType))

            <div class="mt-6 rounded-lg border border-dashed border-gray-300 p-8 text-center">

                <p class="text-sm text-gray-500">
                    Belum ada aktivitas pada periode ini.
                </p>

            </div>

        @else

            {{-- List --}}
            <div class="mt-5 space-y-4">

                @foreach ($result->workloadByType as $item)

                    @php
                        $percentage = $totalActivityMinutes > 0
                            ? round(
                                ($item['durasi_menit'] / $totalActivityMinutes) * 100
                            )
                            : 0;
                    @endphp


                    <div>

                        {{-- Label --}}
                        <div class="flex items-center justify-between gap-4">

                            <div class="min-w-0">

                                <p class="truncate text-sm font-medium text-gray-800">
                                    {{ ucfirst($item['tipe']) }}
                                </p>

                                <p class="mt-0.5 text-xs text-gray-500">
                                    {{ $item['jumlah'] }}
                                    {{ $item['jumlah'] === 1 ? 'aktivitas' : 'aktivitas' }}
                                </p>

                            </div>


                            <div class="shrink-0 text-right">

                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $this->formatDuration($item['durasi_menit']) }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ $percentage }}%
                                </p>

                            </div>

                        </div>


                        {{-- Progress --}}
                        <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-100">

                            <div
                                class="h-full rounded-full bg-gray-800 transition-all"
                                style="width: {{ $percentage }}%"
                            ></div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Footer --}}
            <div class="mt-5 border-t border-gray-100 pt-4">

                <div class="flex items-center justify-between">

                    <span class="text-sm text-gray-500">
                        Total aktivitas spontan
                    </span>

                    <span class="text-sm font-semibold text-gray-900">
                        {{ $this->formatDuration($totalActivityMinutes) }}
                    </span>

                </div>

            </div>

        @endif

    </div>

</div>