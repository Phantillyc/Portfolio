@extends('layouts.app')

@section('title')
    Gallery
@endsection

@section('content')
    {!! breadcrumbs(['Gallery' => 'gallery']) !!}

    <div class="borderhr mb-4">
        @if ($page)
            <x-admin-edit-button name="Gallery Page Text" :object="$page" />
        @endif
        <h1>Gallery</h1>
    </div>

    <div class="card card-body mb-4 bg-light">
        <h4 class="mb-1">Browse the Portfolio</h4>
        <p class="mb-0">Use filters below to quickly find projects, tags, and titles.</p>
    </div>

    @if (config('aldebaran.commissions.enabled') && isset($commissionClasses) && $commissionClasses->count())
        <div class="card card-body mb-4 border-primary">
            <h4 class="mb-1">Interested in a Commission?</h4>
            <p class="mb-2">You can request commissions directly from the commission portal.</p>
            <div class="d-flex flex-wrap">
                <a class="btn btn-primary mr-2 mb-2" href="{{ url('commissions/account') }}">Commission Account</a>
                @foreach ($commissionClasses as $class)
                    <a class="btn btn-outline-primary mr-2 mb-2" href="{{ url('commissions/' . $class->slug) }}">{{ $class->name }} Info</a>
                @endforeach
            </div>
        </div>
    @endif

    {!! $page ? $page->text : '' !!}

    <div>
        {!! Form::open(['method' => 'GET', 'class' => '']) !!}
        <div class="form-inline justify-content-end">
            <div class="form-group mr-3 mb-3">
                {!! Form::text('name', Request::get('name'), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
            </div>
            <div class="form-group mb-3">
                {!! Form::select('project_id', $projects, Request::get('project_id'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="ml-auto w-50 justify-content-end form-group mb-3">
            {!! Form::select('tags[]', $tags, Request::get('tags'), [
                'id' => 'tagList',
                'class' => 'form-control',
                'multiple',
                'placeholder' => 'Tag(s)',
            ]) !!}
        </div>
        <div class="form-inline justify-content-end">
            <div class="form-group mr-3 mb-3">
                {!! Form::select(
                    'sort',
                    [
                        'newest' => 'Newest First',
                        'oldest' => 'Oldest First',
                        'alpha' => 'Sort Alphabetically (A-Z)',
                        'alpha-reverse' => 'Sort Alphabetically (Z-A)',
                        'project' => 'Sort by Project',
                    ],
                    Request::get('sort') ?: 'category',
                    ['class' => 'form-control'],
                ) !!}
            </div>
            <div class="form-group mb-3">
                {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    @if ($pieces->count())
        {!! $pieces->render() !!}

        @include('gallery._flex_' . config('aldebaran.settings.gallery_arrangement'), [
            'pieces' => $pieces,
        ])

        {!! $pieces->render() !!}
    @else
        <p>No pieces found!</p>
    @endif

    <script>
        $(document).ready(function() {
            $('#tagList').selectize({
                maxItems: 10
            });
        });
    </script>
@endsection
