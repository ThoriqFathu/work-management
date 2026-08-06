@if(session('success'))

<div class="mb-5 rounded bg-green-100 border border-green-300 text-green-700 p-4">

    {{ session('success') }}

</div>

@endif

@if($errors->any())

<div class="mb-5 rounded bg-red-100 border border-red-300 text-red-700 p-4">

    <ul class="list-disc pl-5">

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif