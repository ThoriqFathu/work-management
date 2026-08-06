@extends('layouts.app')

@section('title', 'Work Request')

@section('content')

<div class="rounded-lg bg-white shadow">

    @include('work-request.partials.filters')

    @if($items->isEmpty())

        @include('work-request.partials.empty')

    @else

        <div class="hidden lg:block">

            @include('work-request.partials.table')

        </div>

        <div class="lg:hidden">

            @include('work-request.partials.cards')

        </div>

    @endif

    <div class="border-t p-5">

        {{ $items->links() }}

    </div>

</div>

@endsection