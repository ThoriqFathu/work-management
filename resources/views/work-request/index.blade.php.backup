@extends('layouts.app')

@section('title', 'Work Request')

@section('content')

<div class="bg-white rounded-lg shadow">

    <div class="flex items-center justify-between p-5 border-b">

        <form method="GET" class="flex gap-3 flex-wrap">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari..."
                class="border rounded px-3 py-2"
            >

            <select
                name="unit_kerja_id"
                class="border rounded px-3 py-2"
            >
                <option value="">Semua Unit</option>

                @foreach($unitKerjas as $item)

                    <option
                        value="{{ $item->id }}"
                        @selected(request('unit_kerja_id')==$item->id)
                    >
                        {{ $item->nama }}
                    </option>

                @endforeach

            </select>

            <select
                name="status_id"
                class="border rounded px-3 py-2"
            >
                <option value="">Semua Status</option>

                @foreach($statuses as $item)

                    <option
                        value="{{ $item->id }}"
                        @selected(request('status_id')==$item->id)
                    >
                        <span class="px-2 py-1 rounded text-xs bg-gray-200">
                            {{ $item->nama }}
                        </span>
                    </option>

                @endforeach

            </select>

            <select
                name="priority_id"
                class="border rounded px-3 py-2"
            >
                <option value="">Semua Priority</option>

                @foreach($priorities as $item)

                    <option
                        value="{{ $item->id }}"
                        @selected(request('priority_id')==$item->id)
                    >
                        {{ $item->nama }}
                    </option>

                @endforeach

            </select>

            <button class="bg-blue-600 text-white px-4 rounded">
                Filter
            </button>

        </form>

        <a
            href="{{ route('work-request.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg"
        >
            + Work Request
        </a>

    </div>

    <table class="w-full">

        <thead class="bg-gray-100">

        <tr>

            <th class="px-4 py-3 text-left">Kode</th>

            <th class="px-4 py-3 text-left">Judul</th>

            <th class="px-4 py-3 text-left">Unit</th>

            <th class="px-4 py-3 text-left">Kategori</th>

            <th class="px-4 py-3 text-left">Priority</th>

            <th class="px-4 py-3 text-left">Status</th>

            <th class="px-4 py-3 text-center">Aksi</th>

        </tr>

        </thead>

        <tbody>

        @forelse($items as $item)

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

                <td>

                <span
                class="px-2 py-1 rounded text-xs font-semibold"
                style="background-color: {{ $item->priority?->warna }}22;
                color: {{ $item->priority?->warna }}"
                >

                {{ $item->priority?->nama }}

                </span>

                </td>

                <td class="px-4 py-3">
                    <span
                class="px-2 py-1 rounded text-xs font-semibold"
                style="background-color: {{ $item->status->warna }}22;
                color: {{ $item->status->warna }}"
                >

                {{ $item->status->nama }}

                </span>
                </td>

                <td class="px-4 py-3">

                    <div class="flex justify-center gap-2">

                        <a
                            href="{{ route('work-request.edit', $item) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded"
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
                                class="bg-red-600 text-white px-3 py-1 rounded"
                            >
                                Hapus
                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" class="py-12 text-center">

                    <div class="text-gray-400 text-lg">
                        Belum ada Work Request
                    </div>

                    <div class="mt-2">
                        <a
                            href="{{ route('work-request.create') }}"
                            class="text-blue-600 hover:underline"
                        >
                            Buat Work Request pertama
                        </a>
                    </div>

                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    <div class="p-5">

        {{ $items->links() }}

    </div>

</div>

@endsection