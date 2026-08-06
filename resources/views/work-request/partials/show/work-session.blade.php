 <div class="bg-white rounded-lg shadow">
    <div class="mb-6 rounded-lg border bg-blue-50 p-5">
    
        <hr class="my-6">

        <h3 class="mb-4 text-lg font-semibold">

            Work Session

        </h3>

        <div class="space-y-4">

            @forelse($workRequest->workSessions as $session)

            <details class="rounded-lg border bg-white shadow-sm">

                <summary
                    class="cursor-pointer list-none p-5"
                >

                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

                        <div>

                            <div class="font-semibold">

                                {{ $session->started_at->format('d M Y') }}

                            </div>

                            <div class="text-gray-500">

                                {{ $session->started_at->format('H:i') }}

                                -

                                {{ $session->ended_at?->format('H:i') ?? 'Sedang Berjalan' }}

                            </div>

                        </div>

                        <div>

                            @if($session->ended_at)

                                <span
                                    class="rounded bg-green-100 px-3 py-1 text-sm text-green-700"
                                >

                                    {{ $session->durasi_menit }} menit

                                </span>

                            @else

                                <span
                                    class="rounded bg-yellow-100 px-3 py-1 text-sm text-yellow-700"
                                >

                                    Sedang Berjalan

                                </span>

                            @endif

                        </div>

                    </div>

                </summary>

                <div class="border-t p-5">

                    <div class="mb-4">

                        <div class="font-semibold">
                            Catatan
                        </div>

                        <div class="mt-1 whitespace-pre-line text-gray-700">

                            {{ $session->catatan ?: '-' }}

                        </div>

                    </div>

                    <div class="mb-4">

                        <div class="font-semibold">
                            Dikerjakan oleh
                        </div>

                        <div class="text-gray-700">

                            {{ $session->user->name }}

                        </div>

                    </div>

                    <div>

                        <div class="mt-5">

                            <h4 class="mb-4 font-semibold">

                                Tambah Output

                            </h4>

                            @include('work-request.partials.show.work-session-output-form')
                            
                            <div class="mt-3 mb-3 flex items-center justify-between">

                                <h4 class="font-semibold">

                                    Output

                                </h4>


                            </div>

                            <div class="space-y-3">
                                
                                
                                @include('work-request.partials.show.work-session-output-list')

                            </div>


                            

                        </div>

                    </div>

                </div>

            </details>

            @empty

            <div class="rounded-lg border border-dashed p-8 text-center text-gray-400">

                Belum ada Work Session.

            </div>

            @endforelse

        </div>
    </div>
</div>