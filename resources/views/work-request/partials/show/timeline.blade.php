<div class="rounded-lg bg-white shadow">

    <div class="border-b p-5">

        <h2 class="font-semibold text-lg">
            Activity Timeline
        </h2>

    </div>


    <div class="p-5">

        <div class="relative space-y-6">

            @forelse($timeline as $activity)

                <div class="relative pl-8">


                    <div
                        class="absolute left-0 top-1 h-3 w-3 rounded-full bg-blue-600"
                    >
                    </div>


                    <div
                        class="rounded-lg border p-4"
                    >

                        <div class="flex flex-col gap-2 md:flex-row md:justify-between">


                            <div>

                                <div class="font-medium">

                                    {{ $activity->deskripsi }}

                                </div>


                                <div class="mt-1 text-sm text-gray-500">

                                    {{ $activity->user?->name }}

                                </div>

                            </div>


                            <div class="text-sm text-gray-400">

                                {{ $activity->created_at->format('d M Y H:i') }}

                            </div>


                        </div>


                        @if($activity->data_lama || $activity->data_baru)

                            <div class="mt-3 rounded bg-gray-50 p-3 text-sm">


                                @if($activity->data_lama)

                                    <div>

                                        <span class="font-semibold">
                                            Sebelum:
                                        </span>

                                        {{ json_encode($activity->data_lama) }}

                                    </div>

                                @endif


                                @if($activity->data_baru)

                                    <div>

                                        <span class="font-semibold">
                                            Sesudah:
                                        </span>

                                        {{ json_encode($activity->data_baru) }}

                                    </div>

                                @endif


                            </div>

                        @endif


                    </div>


                </div>


            @empty

                <div class="py-10 text-center text-gray-400">

                    Belum ada aktivitas.

                </div>

            @endforelse


        </div>

    </div>

</div>