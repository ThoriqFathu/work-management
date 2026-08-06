<form
    method="POST"
    action="{{ route('work-session-output.store',$session) }}"
    enctype="multipart/form-data"
>

    @csrf

    <div class="grid gap-4">

        <div>

            <label class="mb-1 block text-sm font-medium">

                Nama

            </label>

            <input
                type="text"
                name="nama"
                class="w-full rounded border px-3 py-2"
            >

        </div>

        <div>

            <label class="mb-1 block text-sm font-medium">

                Tipe

            </label>

            <select
                id="tipe-{{ $session->id }}"
                name="tipe"
                class="w-full rounded border px-3 py-2"
            >

                <option value="file">File</option>

                <option value="link">Link</option>

                <option value="text">Text</option>

            </select>

        </div>

        <div
            id="dynamic-input-{{ $session->id }}"
        >

        </div>

        <div>

            <label class="mb-1 block text-sm font-medium">

                Catatan

            </label>

            <textarea
                name="catatan"
                rows="3"
                class="w-full rounded border px-3 py-2"
            ></textarea>

        </div>

        <button
            class="rounded-lg bg-blue-600 px-5 py-3 text-white"
        >

            Simpan Output

        </button>

    </div>

</form>
