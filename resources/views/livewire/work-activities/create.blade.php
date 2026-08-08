@if (session('success')) <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
{{ session('success') }} </div>
@endif

<div class="rounded-xl border border-gray-200 bg-white shadow-sm">

```
<div class="p-5 sm:p-6">

    {{-- Header --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-900">
            Catat Aktivitas
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Catat pekerjaan spontan yang sudah dilakukan.
        </p>
    </div>


    {{-- Form --}}
    <form
        wire:submit="save"
        class="mt-6 space-y-5"
    >

        {{-- UNIt Kerja --}}
        <div>

            <div class="mb-1.5 flex items-center justify-between">

                <label
                    for="unitKerjaId"
                    class="text-sm font-medium text-gray-700"
                >
                    Unit Kerja
                </label>

            </div>

            <select
                id="unitKerjaId"
                wire:model="unitKerjaId"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5
                       text-sm text-gray-900 outline-none transition
                       focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
            >

                <option value="">
                    Pilih Unit Kerja
                </option>

                @foreach ($unitKerjas as $unitKerja)

                    <option value="{{ $unitKerja->id }}">
                        {{ $unitKerja->nama }}
                    </option>

                @endforeach

            </select>

            @error('unitKerjaId')
                <p class="mt-1.5 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>

        {{-- Tipe --}}
        <div>

            <label
                for="tipe"
                class="mb-1.5 block text-sm font-medium text-gray-700"
            >
                Jenis Aktivitas
            </label>

            <select
                id="tipe"
                wire:model="tipe"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5
                       text-sm text-gray-900 outline-none transition
                       focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
            >

                <option value="">
                    Pilih jenis aktivitas
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

            @error('tipe')
                <p class="mt-1.5 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Requester --}}
        <div>

            <div class="mb-1.5 flex items-center justify-between">

                <label
                    for="requesterUnitId"
                    class="text-sm font-medium text-gray-700"
                >
                    Requester
                </label>

                <span class="text-xs text-gray-400">
                    Opsional
                </span>

            </div>

            <select
                id="requesterUnitId"
                wire:model="requesterUnitId"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5
                       text-sm text-gray-900 outline-none transition
                       focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
            >

                <option value="">
                    Tidak ada requester
                </option>

                @foreach ($requesterUnits as $requesterUnit)

                    <option value="{{ $requesterUnit->id }}">
                        {{ $requesterUnit->nama }}
                    </option>

                @endforeach

            </select>

            @error('requesterUnitId')
                <p class="mt-1.5 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Channel --}}
        <div>

            <div class="mb-1.5 flex items-center justify-between">

                <label
                    for="channel"
                    class="text-sm font-medium text-gray-700"
                >
                    Media
                </label>

                <span class="text-xs text-gray-400">
                    Opsional
                </span>

            </div>

            <select
                id="channel"
                wire:model="channel"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5
                       text-sm text-gray-900 outline-none transition
                       focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
            >

                <option value="">
                    Tidak ada
                </option>

                <option value="phone">
                    Phone / Call
                </option>

                <option value="whatsapp">
                    WhatsApp
                </option>

                <option value="telegram">
                    Telegram
                </option>

                <option value="onsite">
                    On-site
                </option>

                <option value="remote">
                    Remote
                </option>

            </select>

            @error('channel')
                <p class="mt-1.5 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Durasi --}}
        <div>

            <label
                for="durasiMenit"
                class="mb-1.5 block text-sm font-medium text-gray-700"
            >
                Durasi
            </label>


            {{-- Quick duration --}}
            <div class="flex flex-wrap gap-2">

                @foreach ([5 => '5m', 10 => '10m', 15 => '15m', 30 => '30m', 60 => '1j'] as $value => $label)

                    <button
                        type="button"
                        wire:click="$set('durasiMenit', {{ $value }})"
                        class="rounded-lg border px-3 py-2 text-sm font-medium transition
                               {{ (int) $durasiMenit === $value
                                   ? 'border-gray-900 bg-gray-900 text-white'
                                   : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                               }}"
                    >
                        {{ $label }}
                    </button>

                @endforeach

            </div>


            {{-- Manual duration --}}
            <div class="relative mt-2">

                <input
                    id="durasiMenit"
                    type="number"
                    min="1"
                    wire:model="durasiMenit"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 pr-16
                           text-sm text-gray-900 outline-none transition
                           placeholder:text-gray-400
                           focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                    placeholder="Masukkan durasi"
                >

                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-gray-400">
                    menit
                </span>

            </div>

            @error('durasiMenit')
                <p class="mt-1.5 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Ringkasan --}}
        <div>

            <label
                for="ringkasan"
                class="mb-1.5 block text-sm font-medium text-gray-700"
            >
                Ringkasan
            </label>

            <textarea
                id="ringkasan"
                wire:model="ringkasan"
                rows="4"
                class="w-full resize-y rounded-lg border border-gray-300 bg-white px-3 py-2.5
                       text-sm text-gray-900 outline-none transition
                       placeholder:text-gray-400
                       focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                placeholder="Contoh: Membantu user poli mengatasi masalah printer tidak mencetak hasil antrean."
            ></textarea>

            @error('ringkasan')
                <p class="mt-1.5 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Submit --}}
        <div class="flex flex-col-reverse gap-2 border-t border-gray-100 pt-5 sm:flex-row sm:justify-end">

            <a
                href="{{ route('work-activities.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300
                       bg-white px-4 py-2.5 text-sm font-medium text-gray-700
                       transition hover:bg-gray-50"
            >
                Batal
            </a>


            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center gap-2 rounded-lg
                       bg-gray-900 px-4 py-2.5 text-sm font-medium text-white
                       transition hover:bg-gray-800
                       disabled:cursor-not-allowed disabled:opacity-60"
            >

                <svg
                    wire:loading
                    class="h-4 w-4 animate-spin"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    />

                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                    />
                </svg>

                <span wire:loading.remove>
                    Simpan Aktivitas
                </span>

                <span wire:loading>
                    Menyimpan...
                </span>

            </button>

        </div>

    </form>

</div>
```

</div>
