<nav class="bg-white shadow">

    <div class="flex items-center justify-between px-4 py-3">

        <div class="flex items-center gap-3">

            <button
                id="btn-sidebar"
                class="rounded p-2 hover:bg-gray-100 md:hidden"
            >
                ☰
            </button>

            <h1 class="font-semibold text-lg">

                @yield('title')

            </h1>

        </div>

        <div>

            {{ auth()->user()->name }}

        </div>

    </div>

</nav>