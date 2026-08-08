<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-gray-900">
                Aktivitas Saya
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Riwayat pekerjaan spontan yang telah dicatat.
            </p>
        </div>

        <a
            href="{{ route('work-activities.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg
                   bg-gray-900 px-4 py-2.5 text-sm font-medium text-white
                   transition hover:bg-gray-800"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Catat Aktivitas
        </a>

    </div>


    {{-- Summary --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        {{-- Total Aktivitas --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Total Aktivitas
                    </p>

                    <p class="mt-2 text-2xl font-semibold text-gray-900">
                        {{ number_format($totalAktivitas) }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Pada periode terpilih
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100">

                    <svg
                        class="h-5 w-5 text-gray-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a3 3 0 006 0M9 5h6"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Total Waktu --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            @php
                $hours = intdiv($totalDurasi, 60);
                $minutes = $totalDurasi % 60;
            @endphp

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Total Waktu
                    </p>

                    <p class="mt-2 text-2xl font-semibold text-gray-900">

                        @if ($hours > 0)
                            {{ $hours }}j
                        @endif

                        @if ($minutes > 0)
                            {{ $minutes }}m
                        @endif

                        @if ($hours === 0 && $minutes === 0)
                            0m
                        @endif

                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Total durasi aktivitas
                    </p>

                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100">

                    <svg
                        class="h-5 w-5 text-gray-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- Filter --}}
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

        <div class="grid grid-cols-1 gap-3 md:grid-cols-4">

            {{-- Search --}}
            <div class="md:col-span-2">

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Pencarian
                </label>

                <div class="relative">

                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">

                        <svg
                            class="h-4 w-4 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                            />
                        </svg>

                    </div>

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari aktivitas..."
                        class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-9 pr-3
                               text-sm text-gray-900 outline-none transition
                               placeholder:text-gray-400
                               focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                    >

                </div>

            </div>


            {{-- Periode --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Periode
                </label>

                <select
                    wire:model.live="filterPeriode"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5
                           text-sm text-gray-700 outline-none transition
                           focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >
                    <option value="today">
                        Hari ini
                    </option>

                    <option value="yesterday">
                        Kemarin
                    </option>

                    <option value="7days">
                        7 hari terakhir
                    </option>

                    <option value="month">
                        Bulan ini
                    </option>

                    <option value="all">
                        Semua
                    </option>
                </select>

            </div>


            {{-- Tipe --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Jenis
                </label>

                <select
                    wire:model.live="filterTipe"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5
                           text-sm text-gray-700 outline-none transition
                           focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >

                    <option value="">
                        Semua jenis
                    </option>

                    <option value="support">
                        Support User
                    </option>

                    <option value="troubleshooting">
                        Troubleshooting
                    </option>

                    <option value="maintenance">
                        Maintenance
                    </option>

                    <option value="monitoring">
                        Monitoring
                    </option>

                    <option value="koordinasi">
                        Koordinasi
                    </option>

                    <option value="meeting">
                        Meeting
                    </option>

                    <option value="administrasi">
                        Administrasi
                    </option>

                    <option value="lainnya">
                        Lainnya
                    </option>

                </select>

            </div>

        </div>


        {{-- Requester --}}
        <div class="mt-3">

            <label class="mb-1.5 block text-sm font-medium text-gray-700">
                Requester
            </label>

            <select
                wire:model.live="filterRequester"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5
                       text-sm text-gray-700 outline-none transition
                       focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
            >

                <option value="">
                    Semua requester
                </option>

                @foreach ($requesterUnits as $requesterUnit)

                    <option value="{{ $requesterUnit->id }}">
                        {{ $requesterUnit->nama }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>


    {{-- Activity List --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        @forelse ($activities as $activity)

            <div class="border-b border-gray-100 p-5 last:border-b-0">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                    {{-- Content --}}
                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">

                            {{-- Type --}}
                            <span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                                {{ ucfirst($activity->tipe) }}
                            </span>


                            {{-- Channel --}}
                            @if ($activity->channel)

                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                    {{ ucfirst($activity->channel) }}
                                </span>

                            @endif


                            {{-- Requester --}}
                            @if ($activity->requesterUnit)

                                <span class="text-xs text-gray-500">
                                    {{ $activity->requesterUnit->nama }}
                                </span>

                            @endif

                        </div>


                        {{-- Ringkasan --}}
                        <p class="mt-2 text-sm font-medium text-gray-900">
                            {{ $activity->ringkasan }}
                        </p>


                        {{-- Created --}}
                        <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">

                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>

                            {{ $activity->created_at->translatedFormat('d M Y H:i') }}

                        </div>

                    </div>


                    {{-- Duration --}}
                    <div class="shrink-0 sm:text-right">

                        <p class="text-sm font-semibold text-gray-900">

                            @if ($activity->durasi_menit >= 60)

                                {{ intdiv($activity->durasi_menit, 60) }}j

                                @if ($activity->durasi_menit % 60)
                                    {{ $activity->durasi_menit % 60 }}m
                                @endif

                            @else

                                {{ $activity->durasi_menit }}m

                            @endif

                        </p>

                        <p class="mt-0.5 text-xs text-gray-400">
                            durasi
                        </p>

                        <button
                            type="button"
                            wire:click="delete({{ $activity->id }})"
                            wire:confirm="Yakin ingin menghapus aktivitas ini?"
                            class="rounded-lg border border-red-200 bg-white px-3 py-2
                                text-sm font-medium text-red-600
                                transition hover:bg-red-50"
                        >
                            Hapus
                        </button>

                    </div>

                </div>

            </div>

        @empty

            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">

                    <svg
                        class="h-6 w-6 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a2 2 0 011.414.586L19 8.414A2 2 0 0119.586 10v9a2 2 0 01-2 2z"
                        />
                    </svg>

                </div>

                <p class="mt-4 text-sm font-medium text-gray-900">
                    Belum ada aktivitas
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Aktivitas spontan yang kamu catat akan muncul di sini.
                </p>

                <a
                    href="{{ route('work-activities.create') }}"
                    class="mt-5 inline-flex items-center gap-2 rounded-lg
                           bg-gray-900 px-4 py-2 text-sm font-medium text-white
                           transition hover:bg-gray-800"
                >
                    Catat Aktivitas
                </a>

            </div>

        @endforelse

    </div>


    {{-- Pagination --}}
    @if ($activities->hasPages())

        <div class="pt-2">
            {{ $activities->links() }}
        </div>

    @endif

</div>