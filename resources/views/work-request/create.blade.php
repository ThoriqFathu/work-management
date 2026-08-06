@extends('layouts.app')

@section('title', 'Tambah Work Request')

@section('content')

<div class="bg-white rounded-lg shadow">

    <div class="border-b px-6 py-4">
        <h2 class="text-lg font-semibold">
            Tambah Work Request
        </h2>
    </div>

    <form action="{{ route('work-request.store') }}" method="POST">

        @csrf

        <div class="p-6 space-y-5">

            {{-- Judul --}}
            <div>
                <label class="block mb-2 font-medium">
                    Judul <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="judul"
                    value="{{ old('judul') }}"
                    class="w-full border rounded-lg px-4 py-2"
                >

                @error('judul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block mb-2 font-medium">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    rows="5"
                    class="w-full border rounded-lg px-4 py-2"
                >{{ old('deskripsi') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-5">

                {{-- Unit Kerja --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Unit Kerja
                    </label>

                    <select
                        name="unit_kerja_id"
                        class="w-full border rounded-lg px-4 py-2"
                    >

                        <option value="">
                            -- Pilih --
                        </option>

                        @foreach($unitKerjas as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(old('unit_kerja_id') == $item->id)
                            >
                                {{ $item->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Requester Unit --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Unit Peminta
                    </label>

                    <select
                        name="requester_unit_id"
                        class="w-full border rounded-lg px-4 py-2"
                    >

                        <option value="">
                            -- Pilih --
                        </option>

                        @foreach($requesterUnits as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(old('requester_unit_id') == $item->id)
                            >
                                {{ $item->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="grid grid-cols-3 gap-5">

                {{-- Kategori --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Kategori
                    </label>

                    <select
                        name="category_id"
                        class="w-full border rounded-lg px-4 py-2"
                    >

                        @foreach($categories as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(old('category_id') == $item->id)
                            >
                                {{ $item->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Priority --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Priority
                    </label>

                    <select
                        name="priority_id"
                        class="w-full border rounded-lg px-4 py-2"
                    >

                        @foreach($priorities as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(old('priority_id') == $item->id)
                            >
                                {{ $item->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Status --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Status
                    </label>

                    <select
                        name="status_id"
                        class="w-full border rounded-lg px-4 py-2"
                    >

                        @foreach($statuses as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(old('status_id') == $item->id)
                            >
                                {{ $item->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

        <div class="border-t px-6 py-4 flex justify-end gap-3">

            <a
                href="{{ route('work-request.index') }}"
                class="px-5 py-2 border rounded-lg"
            >
                Batal
            </a>

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg"
            >
                Simpan
            </button>

        </div>

    </form>

</div>

@endsection