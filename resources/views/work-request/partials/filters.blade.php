<div class="border-b p-5">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <form method="GET" class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:flex">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari..."
                class="rounded border px-3 py-2"
            >

            <select
                name="unit_kerja_id"
                class="rounded border px-3 py-2"
            >
                <option value="">Semua Unit</option>

                @foreach($unitKerjas as $item)

                    <option
                        value="{{ $item->id }}"
                        @selected(request('unit_kerja_id') == $item->id)
                    >
                        {{ $item->nama }}
                    </option>

                @endforeach

            </select>

            <select
                name="status_id"
                class="rounded border px-3 py-2"
            >
                <option value="">Semua Status</option>

                @foreach($statuses as $item)

                    <option
                        value="{{ $item->id }}"
                        @selected(request('status_id') == $item->id)
                    >
                        {{ $item->nama }}
                    </option>

                @endforeach

            </select>

            <select
                name="priority_id"
                class="rounded border px-3 py-2"
            >
                <option value="">Semua Priority</option>

                @foreach($priorities as $item)

                    <option
                        value="{{ $item->id }}"
                        @selected(request('priority_id') == $item->id)
                    >
                        {{ $item->nama }}
                    </option>

                @endforeach

            </select>

            <button
                class="rounded bg-blue-600 px-4 py-2 text-white"
            >
                Filter
            </button>

        </form>

        <a
            href="{{ route('work-request.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-white"
        >
            + Work Request
        </a>

    </div>

</div>