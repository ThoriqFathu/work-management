@forelse($session->outputs as $output)

    <div
        class="rounded-lg border p-4"
    >

        <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">

            <div class="flex-1">

                <div class="font-semibold">

                    {{ $output->nama }}

                </div>

                <div class="mt-1 text-xs uppercase text-gray-500">

                    {{ $output->tipe }}

                </div>

                @if($output->catatan)

                    <div class="mt-2 text-sm text-gray-600">

                        {{ $output->catatan }}

                    </div>

                @endif

                <div class="mt-3">

                    @switch($output->tipe)

                        @case('file')

                            <a
                                href="{{ asset('storage/'.$output->value) }}"
                                target="_blank"
                                class="text-blue-600 hover:underline"
                            >

                                📄 Download File

                            </a>

                            @break

                        @case('link')

                            <a
                                href="{{ $output->value }}"
                                target="_blank"
                                class="break-all text-blue-600 hover:underline"
                            >

                                {{ $output->value }}

                            </a>

                            @break

                        @case('text')

                            <pre
                                class="overflow-auto rounded bg-gray-100 p-3 text-sm"
                            >{{ $output->value }}</pre>

                            @break

                    @endswitch

                </div>

            </div>

            <div>

                <form
                    method="POST"
                    action="{{ route('work-session-output.destroy',$output) }}"
                    onsubmit="return confirm('Hapus output?')"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        class="rounded bg-red-600 px-3 py-2 text-sm text-white"
                    >

                        Hapus

                    </button>

                </form>

            </div>

        </div>

    </div>

@empty

    <div class="rounded border border-dashed p-6 text-center text-gray-400">

        Belum ada output.

    </div>

@endforelse