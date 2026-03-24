@extends('layouts.app')

@section('title')
    {{ $page->name }}
@endsection

@section('content')
    {!! breadcrumbs([$page->name => $page->key]) !!}

    <div class="borderhr mb-4">
        <x-admin-edit-button name="Page" :object="$page" />
        <h1>{{ $page->name }}</h1>
        <p>Last updated {{ $page->updated_at->toFormattedDateString() }}</p>
    </div>

    @if (config('aldebaran.commissions.enabled') && $page->key == 'about')
        <div class="card card-body mb-4 border-primary">
            <h4 class="mb-2">Commissions</h4>
            <p class="mb-2">Looking to commission me? Start from the commission portal.</p>
            <div class="d-flex flex-wrap">
                <a href="{{ url('commissions/account') }}" class="btn btn-primary mr-2 mb-2">Commission Account</a>
                @foreach ($commissionClasses as $class)
                    <a href="{{ url('commissions/' . $class->slug) }}" class="btn btn-outline-primary mr-2 mb-2">{{ $class->name }} Info</a>
                @endforeach
            </div>
        </div>
    @endif

    {!! $page->text !!}
@endsection
