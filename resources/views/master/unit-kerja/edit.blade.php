@extends('layouts.app')

@section('title', 'Edit Unit Kerja')

@section('content')

<div class="bg-white rounded-lg shadow p-6 max-w-xl">

    <form
        method="POST"
        action="{{ route('master.unit-kerja.update', $unitKerja) }}"
    >
        @method('PUT')

        @csrf

        <div class="mb-4">

            <label class="block mb-2">

                Nama Unit Kerja

            </label>

            <input
                type="text"
                name="nama"
                value="{{ old('nama', $unitKerja->nama) }}"
                class="border rounded-lg w-full px-4 py-2"
            >

            @error('nama')

                <small class="text-red-500">

                    {{ $message }}

                </small>

            @enderror

        </div>

        <div class="mb-5">

            <label class="block mb-2">

                Status

            </label>

            <select
                name="aktif"
                class="border rounded-lg w-full px-4 py-2"
            >

                <option value="1">
                    Aktif
                </option>

                <option value="0">
                    Tidak Aktif
                </option>

            </select>

        </div>

        <button
            class="bg-blue-600 text-white px-5 py-2 rounded"
        >

            Simpan

        </button>

    </form>

</div>

@endsection