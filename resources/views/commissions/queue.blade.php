@extends('layouts.app')

@section('title')
    {{ $class->name }} Queue
@endsection

@section('content')
    {!! breadcrumbs([
        $class->name . ' Commissions' => 'commissions/' . $class->slug,
        'Queue' => 'commissions/' . $class->slug . '/queue',
    ]) !!}

    <div class="borderhr mb-4">
        <h1>
            {{ $class->name }} Queue
            <div class="float-right ml-2">
                <a class="btn btn-primary" href="{{ url('commissions/account') }}">Commission Account</a>
                <a class="btn btn-secondary" href="{{ url('commissions/' . $class->slug) }}">Back to Commission Info</a>
            </div>
        </h1>
    </div>

    <p>This queue is account-protected. It only shows the commissioner name, image count, and current status.</p>

    @if ($commissions->count())
        @foreach ($commissions as $commission)
            <div class="card card-body mb-4">
                <div class="borderhr">
                    <h3>{{ $loop->iteration }} ・ {{ $commission->commissioner->name }}</h3>
                    <p>
                        Images Requested: {{ $commission->image_count }} ・
                        Status: {{ $commission->status }} ・
                        Progress: {{ $commission->progress }}
                    </p>
                </div>
            </div>
        @endforeach
    @else
        <p>The queue is currently empty.</p>
    @endif

@endsection
