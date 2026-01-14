@extends('shop.layout')

@section('title', $event->title)

@section('content')
<section class="py-5">
    <div class="container">

        {{-- TIÊU ĐỀ --}}
        <div class="text-center mb-4">
            <h1 class="fw-bold">
                {{ $event->title }}
            </h1>

            @if($event->subtitle)
                <p class="text-muted fs-5">
                    {{ $event->subtitle }}
                </p>
            @endif
        </div>

        {{-- ẢNH CHÍNH --}}
        @if($event->thumbnail)
            <div class="mb-4 text-center">
                <img src="{{ asset('storage/'.$event->thumbnail) }}"
                     class="img-fluid rounded shadow-sm"
                     style="max-height:450px; object-fit:cover;">
            </div>
        @endif

        {{-- NỘI DUNG --}}
        <div class="event-content fs-5">
            {!! $event->content !!}
        </div>

    </div>
</section>
@endsection
