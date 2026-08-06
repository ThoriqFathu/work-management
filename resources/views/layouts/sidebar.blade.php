<aside class="hidden md:flex w-64 bg-slate-800 text-white flex-col">

    <div class="px-6 py-5 border-b border-slate-700">
        <h1 class="text-xl font-bold">
            Work Management
        </h1>
    </div>

    @include('layouts.sidebar-menu')

    <div class="border-t border-slate-700 p-4">

        <div class="mb-3">

            <div class="font-medium">
                {{ auth()->user()->name }}
            </div>

            <div class="text-sm text-slate-400">
                {{ auth()->user()->email }}
            </div>

        </div>

        <form action="{{ route('logout') }}" method="POST">

            @csrf

            <button
                class="w-full rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
            >
                Logout
            </button>

        </form>

    </div>

</aside>