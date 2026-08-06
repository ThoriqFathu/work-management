<div
    id="mobile-sidebar"
    class="fixed inset-0 z-50 hidden bg-black/50"
>
    <div class="flex h-full w-72 flex-col bg-slate-800 text-white shadow-xl">

        <div class="flex items-center justify-between border-b border-slate-700 p-5">

            <h2 class="font-bold">
                Menu
            </h2>

            <button
                id="btn-close-sidebar"
                class="text-xl"
            >
                ✕
            </button>

        </div>

        <div class="flex-1 overflow-y-auto">

            @include('layouts.sidebar-menu')

        </div>

        <div class="border-t border-slate-700 p-4">

            <div class="mb-3">

                <div class="font-medium">
                    {{ auth()->user()->name }}
                </div>

                <div class="text-sm text-slate-400">
                    {{ auth()->user()->email }}
                </div>

            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    class="w-full rounded-lg bg-red-600 py-2 hover:bg-red-700"
                >
                    Logout
                </button>

            </form>

        </div>

    </div>

</div>