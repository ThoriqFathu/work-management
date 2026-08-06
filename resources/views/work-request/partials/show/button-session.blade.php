<div class="bg-white rounded-lg shadow">

    <div class="mb-6 rounded-lg border bg-blue-50 p-5">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>

                <div class="text-sm text-gray-500">
                    Total Waktu Pengerjaan
                </div>

                <div class="mt-1 text-3xl font-bold">
                    {{ $totalDuration }}
                </div>

            </div>

            <div>

                @if($activeSession)

                    @if($activeSession->work_request_id == $workRequest->id)

                        <form
                            method="POST"
                            action="{{ route('work-session.stop', $activeSession) }}"
                        >

                            @csrf
                            @method('PATCH')

                            <button
                                class="rounded-lg bg-red-600 px-5 py-3 text-white"
                            >
                                ■ Selesaikan Kerja
                            </button>

                        </form>

                    @else

                        <div class="rounded-lg bg-yellow-100 p-4">

                            <div class="font-semibold">

                                Anda sedang mengerjakan task lain.

                            </div>

                            <div class="text-sm text-gray-500">

                                Selesaikan task tersebut terlebih dahulu.

                            </div>

                        </div>

                    @endif

                @else

                    <form
                        method="POST"
                        action="{{ route('work-session.start', $workRequest) }}"
                    >

                        @csrf

                        <button
                            class="rounded-lg bg-green-600 px-5 py-3 text-white"
                        >
                            ▶ Mulai Kerja
                        </button>

                    </form>

                @endif

            </div>

        </div>

    </div>
</div>