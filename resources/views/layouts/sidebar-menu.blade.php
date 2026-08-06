<nav class="flex-1 p-4 space-y-1">

    <a
        href="{{ route('dashboard') }}"
        class="block rounded-lg px-4 py-2 hover:bg-slate-700"
    >
        Dashboard
    </a>

    <a
        href="{{ route('work-request.index') }}"
        class="block rounded-lg px-4 py-2 hover:bg-slate-700"
    >
        Work Request
    </a>

    <hr class="border-slate-600 my-4">

    <p class="px-4 text-xs uppercase text-slate-400">
        Master
    </p>

    <a
        href="{{ route('master.unit-kerja.index') }}"
        class="block rounded-lg px-4 py-2 hover:bg-slate-700"
    >
        Unit Kerja
    </a>

    <a
        href="{{ route('master.requester-unit.index') }}"
        class="block rounded-lg px-4 py-2 hover:bg-slate-700"
    >
        Requester Unit
    </a>

    <a
        href="{{ route('master.category.index') }}"
        class="block rounded-lg px-4 py-2 hover:bg-slate-700"
    >
        Category
    </a>

    <a
        href="{{ route('master.priority.index') }}"
        class="block rounded-lg px-4 py-2 hover:bg-slate-700"
    >
        Priority
    </a>

    <a
        href="{{ route('master.status.index') }}"
        class="block rounded-lg px-4 py-2 hover:bg-slate-700"
    >
        Status
    </a>

    <a
        href="{{ route('master.label.index') }}"
        class="block rounded-lg px-4 py-2 hover:bg-slate-700"
    >
        Label
    </a>

</nav>