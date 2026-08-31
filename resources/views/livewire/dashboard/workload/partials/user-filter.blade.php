{{-- Filter Periode --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm">

   

    <div class="p-5">

        <div class="flex flex-col gap-4">

            {{-- Filter Header --}}
            <div>
                <h2 class="font-semibold text-gray-900">
                    USer
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Pilih User untuk melihat beban kerja.
                </p>
            </div>


            <div>
                <label
                    for="userId"
                    class="mb-1 block text-sm font-medium text-gray-700"
                >
                    User
                </label>

                <select
                    id="userId"
                    wire:model.live="userId"
                    class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                >
                    <option value="">
                        Semua User
                    </option>

                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

    </div>

</div>