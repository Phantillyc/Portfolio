@extends('layouts.app')

@section('content')

    @if ($page)
        {!! $page->text !!}
    @else
        <p>Please finish initial site setup!</p>
    @endif

    @if (config('aldebaran.commissions.enabled'))
        <div class="card mb-4 border-primary">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="mb-1">Commission Portal</h2>
                    <p class="mb-0">Create an account to request commissions and track progress.</p>
                </div>
                <a href="{{ url('commissions/account') }}" class="btn btn-primary mt-2 mt-md-0">Sign In / Create Account</a>
            </div>
        </div>
        @foreach ($commissionClasses as $class)
            @php
                $mode = Settings::get($class->slug . '_comms_mode') ?: (Settings::get($class->slug . '_comms_open') == 1 ? 'open' : 'closed');
                $modeText = Settings::get($class->slug . '_' . $mode . '_text');
            @endphp
            <div class="card mb-4">
                <div class="card-header">
                    <h2>{{ ucfirst($class->name) }} Commissions ・
                        <span class="text-{{ $mode == 'open' ? 'success' : ($mode == 'manual' ? 'warning' : 'danger') }}">{{ ucfirst($mode) }}</span>
                    </h2>
                    @if (Settings::get($class->slug . '_status'))
                        <h6>{!! Settings::get($class->slug . '_status') !!}</h6>
                    @endif
                </div>
                <div class="card-body text-center">
                    @if ($modeText)
                        <div class="text-left mb-3">{!! $modeText !!}</div>
                    @endif
                    <div class="row">
                        <div class="col-md mb-2"><a href="{{ url('commissions/' . $class->slug . '/tos') }}" class="btn btn-primary">Terms of Service</a></div>
                        <div class="col-md mb-2"><a href="{{ url('commissions/' . $class->slug) }}" class="btn @if ($mode == 'open') btn-success @else btn-primary @endif">Commission
                                Information</a></div>
                        <div class="col-md mb-2"><a href="{{ url('commissions/' . $class->slug . '/queue') }}" class="btn btn-primary">Queue Status</a></div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if (config('aldebaran.settings.email_features') && Settings::get('display_mailing_lists') && $mailingLists->count())
        <div class="card mb-4">
            <div class="card-header">
                <h4>Mailing Lists</h4>
            </div>
            <div class="card-body">
                @foreach ($mailingLists as $list)
                    <x-admin-edit-button name="Mailing List" :object="$list" />
                    <div class="float-right">
                        <a href="{{ $list->url }}" class="btn btn-primary">Subscribe</a>
                    </div>
                    <h5>{{ $list->name }}</h5>
                    {!! $list->description !!}
                    {!! !$loop->last ? '<hr/>' : '' !!}
                @endforeach
            </div>
        </div>
    @endif

@endsection
