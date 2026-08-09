<div class="rounded-lg bg-white shadow">

    <div class="border-b p-5">

        <h2 class="text-lg font-semibold">
            Activity Timeline
        </h2>

    </div>

    <div class="divide-y">

        @forelse($timeline as $item)

            <div class="flex gap-4 p-5">

                <div
                    class="mt-1 h-3 w-3 rounded-full"
                    style="background: {{ $item['color'] }}"
                ></div>

                <div class="flex-1">

                    <div class="flex flex-col gap-1 md:flex-row md:justify-between">

                        <div>

                            <div class="font-semibold">

                                {{ $item['title'] }}

                            </div>

                            <div class="text-sm text-gray-500">

                                {{ $item['user']?->name }}

                            </div>

                        </div>

                        <div class="text-sm text-gray-400">

                            {{ $item['created_at']->format('d M Y H:i') }}

                        </div>

                    </div>

                    @if(count($item['details']))

                        <div class="mt-3 rounded-lg bg-gray-50 p-3">

                           @foreach($item['details'] as $detail)

                            <div class="flex justify-between border-b py-2">

                                <div class="text-gray-500">

                                    {{ $detail['label'] }}

                                </div>

                                <div>

                                    @if(array_key_exists('before', $detail))

                                        <div>
                                            {{ $detail['before'] ?? '-' }}
                                        </div>

                                        <div class="text-center text-gray-400">
                                            ↓
                                        </div>

                                        <div class="font-semibold">
                                            {{ $detail['after'] ?? '-' }}
                                        </div>

                                    @else

                                        {{ $detail['value'] ?? '-' }}

                                    @endif

                                </div>

                            </div>

                        @endforeach

                        </div>

                    @endif

                </div>

            </div>

        @empty

            <div class="p-10 text-center text-gray-400">

                Belum ada aktivitas.

            </div>

        @endforelse

    </div>

</div>