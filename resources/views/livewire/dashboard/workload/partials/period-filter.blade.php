{{-- Filter Periode --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm">

    <div class="p-5">

        <div class="flex flex-col gap-4">

            {{-- Filter Header --}}
            <div>
                <h2 class="font-semibold text-gray-900">
                    Periode
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Pilih periode untuk melihat beban kerja.
                </p>
            </div>


            {{-- Preset Periode --}}
            <div class="flex flex-wrap gap-2">

                <button
                    type="button"
                    wire:click="$set('periode', 'bulan_ini')"
                    class="rounded-lg border px-4 py-2 text-sm font-medium transition
                        {{ $periode === 'bulan_ini'
                            ? 'border-gray-900 bg-gray-900 text-white'
                            : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                        }}"
                >
                    Bulan ini
                </button>


                <button
                    type="button"
                    wire:click="$set('periode', 'bulan_lalu')"
                    class="rounded-lg border px-4 py-2 text-sm font-medium transition
                        {{ $periode === 'bulan_lalu'
                            ? 'border-gray-900 bg-gray-900 text-white'
                            : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                        }}"
                >
                    Bulan lalu
                </button>


                <button
                    type="button"
                    wire:click="$set('periode', '7_hari')"
                    class="rounded-lg border px-4 py-2 text-sm font-medium transition
                        {{ $periode === '7_hari'
                            ? 'border-gray-900 bg-gray-900 text-white'
                            : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                        }}"
                >
                    7 hari terakhir
                </button>


                <button
                    type="button"
                    wire:click="$set('periode', 'custom')"
                    class="rounded-lg border px-4 py-2 text-sm font-medium transition
                        {{ $periode === 'custom'
                            ? 'border-gray-900 bg-gray-900 text-white'
                            : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                        }}"
                >
                    Rentang tanggal
                </button>

            </div>


            {{-- Custom Date --}}
            @if ($periode === 'custom')

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Mulai --}}
                    <div>

                        <label
                            for="startDate"
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Mulai
                        </label>

                        <input
                            id="startDate"
                            type="date"
                            wire:model.live="startDate"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5
                                   text-sm text-gray-900 outline-none transition
                                   focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                        >

                    </div>


                    {{-- Sampai --}}
                    <div>

                        <label
                            for="endDate"
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Sampai
                        </label>

                        <input
                            id="endDate"
                            type="date"
                            wire:model.live="endDate"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5
                                   text-sm text-gray-900 outline-none transition
                                   focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                        >

                    </div>

                </div>

            @endif


            {{-- Active Period --}}
            <div class="border-t border-gray-100 pt-3">

                <p class="text-sm text-gray-500">
                    Periode:

                    <span class="font-medium text-gray-700">
                        {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}
                        —
                        {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                    </span>
                </p>

            </div>

        </div>

    </div>

</div>