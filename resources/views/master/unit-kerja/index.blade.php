@extends('layouts.app')

@section('title', 'Unit Kerja')

@section('content')

<div class="bg-white rounded-lg shadow">

    <div class="flex items-center justify-between p-5 border-b">

        <form method="GET">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari unit kerja..."
                class="border rounded-lg px-4 py-2 w-80"
            >

        </form>

        <a
            href="{{ route('master.unit-kerja.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
        >
            + Tambah
        </a>

    </div>

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="px-5 py-3 text-left">No</th>

                <th class="px-5 py-3 text-left">Nama</th>

                <th class="px-5 py-3 text-center">Status</th>

                <th class="px-5 py-3 text-center">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($items as $item)

            <tr class="border-t">

                <td class="px-5 py-3">

                    {{ $items->firstItem() + $loop->index }}

                </td>

                <td class="px-5 py-3">

                    {{ $item->nama }}

                </td>

                <td class="px-5 py-3 text-center">

                    @if($item->aktif)

                        <span class="text-green-600">
                            Aktif
                        </span>

                    @else

                        <span class="text-red-600">
                            Tidak Aktif
                        </span>

                    @endif

                </td>

                <td class="px-5 py-3">

                    <div class="flex justify-center gap-2">

                        <a
                            href="{{ route('master.unit-kerja.edit', $item) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded"
                        >
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route('master.unit-kerja.destroy', $item) }}"
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

                <td colspan="4" class="text-center py-10">

                    Tidak ada data.

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