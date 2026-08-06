<tr class="border-t hover:bg-gray-50">

    <td class="px-4 py-3">
        {{ $item->kode }}
    </td>

    <td class="px-4 py-3">

        <a
            href="{{ route('work-request.show', $item) }}"
            class="text-blue-600 hover:underline"
        >
            {{ $item->judul }}
        </a>

    </td>

    <td class="px-4 py-3">
        {{ $item->unitKerja?->nama }}
    </td>

    <td class="px-4 py-3">
        {{ $item->category?->nama }}
    </td>

    <td class="px-4 py-3">

        <span
            class="rounded px-2 py-1 text-xs font-semibold"
            style="background:{{ $item->priority?->warna }}22;color:{{ $item->priority?->warna }}"
        >
            {{ $item->priority?->nama }}
        </span>

    </td>

    <td class="px-4 py-3">

        <span
            class="rounded px-2 py-1 text-xs font-semibold"
            style="background:{{ $item->status?->warna }}22;color:{{ $item->status?->warna }}"
        >
            {{ $item->status?->nama }}
        </span>

    </td>

    <td class="px-4 py-3">

        <div class="flex justify-center gap-2">

            <a
                href="{{ route('work-request.edit', $item) }}"
                class="rounded bg-yellow-500 px-3 py-1 text-white"
            >
                Edit
            </a>

            <form
                method="POST"
                action="{{ route('work-request.destroy', $item) }}"
                onsubmit="return confirm('Hapus data ini?')"
            >

                @csrf
                @method('DELETE')

                <button
                    class="rounded bg-red-600 px-3 py-1 text-white"
                >
                    Hapus
                </button>

            </form>

        </div>

    </td>

</tr>