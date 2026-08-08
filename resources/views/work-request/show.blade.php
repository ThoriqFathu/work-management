@extends('layouts.app')

@section('title', $workRequest->kode)

@section('content')
    @include('work-request.partials.show.button-session')
    
    @include('work-request.partials.show.info')

    @include('work-request.partials.show.work-session')

    
    @include('work-request.partials.show.timeline')



    

    <script>

        document.querySelectorAll("select[id^='tipe-']").forEach(select => {

            render(select);

            select.addEventListener("change", function () {

                render(this);

            });

        });

        function render(select){

            const id = select.id.replace('tipe-','');

            const target = document.getElementById(
                'dynamic-input-'+id
            );

            if(select.value==="file"){

                target.innerHTML=`
                    <label class="mb-1 block text-sm font-medium">

                        File

                    </label>

                    <input
                        type="file"
                        name="file"
                        class="w-full rounded border px-3 py-2"
                    >
                `;

            }

            if(select.value==="link"){

                target.innerHTML=`
                    <label class="mb-1 block text-sm font-medium">

                        Link

                    </label>

                    <input
                        type="url"
                        name="url"
                        class="w-full rounded border px-3 py-2"
                        placeholder="https://..."
                    >
                `;

            }

            if(select.value==="text"){

                target.innerHTML=`
                    <label class="mb-1 block text-sm font-medium">

                        Isi

                    </label>

                    <textarea
                        name="content"
                        rows="6"
                        class="w-full rounded border px-3 py-2"
                    ></textarea>
                `;

            }

        }

    </script>

@endsection
