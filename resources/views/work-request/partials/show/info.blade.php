 <div class="bg-white rounded-lg shadow">

        <div class="border-b p-6">

            <div class="text-sm text-gray-500">
                {{ $workRequest->kode }}
            </div>

            <h1 class="mt-1 text-2xl font-bold">
                {{ $workRequest->judul }}
            </h1>

        </div>

        <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="text-sm text-gray-500">Unit Kerja</p>
                    <p class="font-medium">{{ $workRequest->unitKerja?->nama }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Requester</p>
                    <p class="font-medium">{{ $workRequest->requesterUnit?->nama }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Kategori</p>
                    <p class="font-medium">{{ $workRequest->category?->nama }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Priority</p>

                    <span class="inline-flex rounded-full px-3 py-1 text-sm text-white"
                        style="background-color: {{ $workRequest->priority?->warna }}">
                        {{ $workRequest->priority?->nama }}
                    </span>

                </div>

                <div class="md:col-span-2">

                    <p class="text-sm text-gray-500 mb-2">
                        Status
                    </p>

                    <span class="inline-flex rounded-full px-3 py-1 text-sm text-white"
                        style="background-color: {{ $workRequest->status?->warna }}">
                        {{ $workRequest->status?->nama }}
                    </span>

                    <div class="mt-4">

                        <p class="text-sm text-gray-500 mb-2">
                            Ubah Status
                        </p>

                        <div class="flex flex-wrap gap-2">

                            @foreach ($statuses as $status)
                                <form method="POST" action="{{ route('work-request.change-status', $workRequest) }}">
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="status_id" value="{{ $status->id }}">

                                    <button type="submit"
                                        class="rounded-lg px-3 py-2 text-sm font-medium text-white transition hover:opacity-90"
                                        style="background-color: {{ $status->warna }}">
                                        {{ $status->nama }}
                                    </button>

                                </form>
                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

            <div class="mt-5 mb-4">

                <h3 class="font-semibold mb-3">

                    Deskripsi

                </h3>

                <div class="whitespace-pre-line">

                    {{ $workRequest->deskripsi }}

                </div>

            </div>
            

            
        </div>
    </div>