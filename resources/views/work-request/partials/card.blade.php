<div class="p-4">

    <div class="flex items-start justify-between">

        <div>

            <a
                href="{{ route('work-request.show', $item) }}"
                class="font-semibold text-blue-600"
            >
                {{ $item->judul }}
            </a>

            <div class="text-sm text-gray-500">
                {{ $item->kode }}
            </div>

        </div>

        <span
            class="rounded px-2 py-1 text-xs font-semibold"
            style="background:{{ $item->status?->warna }}22;color:{{ $item->status?->warna }}"
        >
            {{ $item->status?->nama }}
        </span>

    </div>

    <div class="mt-3 space-y-2 text-sm">

        <div><strong>Unit:</strong> {{ $item->unitKerja?->nama }}</div>

        <div><strong>Kategori:</strong> {{ $item->category?->nama }}</div>

        <div>

            <strong>Priority:</strong>

            <span
                class="rounded px-2 py-1 text-xs font-semibold"
                style="background:{{ $item->priority?->warna }}22;color:{{ $item->priority?->warna }}"
            >
                {{ $item->priority?->nama }}
            </span>

        </div>

    </div>

    <div class="mt-4 flex gap-2">

        <a
            href="{{ route('work-request.edit', $item) }}"
            class="flex-1 rounded bg-yellow-500 py-2 text-center text-white"
        >
            Edit
        </a>

        <form
            method="POST"
            action="{{ route('work-request.destroy', $item) }}"
            class="flex-1"
            onsubmit="return confirm('Hapus data ini?')"
        >

            @csrf
            @method('DELETE')

            <button
                class="w-full rounded bg-red-600 py-2 text-white"
            >
                Hapus
            </button>

        </form>

    </div>

</div>