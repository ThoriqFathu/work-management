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

        @foreach($items as $item)

            @include('work-request.partials.row')

        @endforeach

    </tbody>

</table>