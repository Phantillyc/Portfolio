@extends('layouts.app')

@section('title')
    Commission Login
@endsection

@section('content')
    <div class="borderhr mb-4">
        <h1>Commission Login</h1>
    </div>

    @if($client)
        <div class="alert alert-success">
            Signed in as <strong>{{ $client->username }}</strong>.
        </div>
        {!! Form::open(['url' => 'commission-auth/logout']) !!}
            {!! Form::submit('Sign Out', ['class' => 'btn btn-secondary']) !!}
        {!! Form::close() !!}
    @else
        <div class="card card-body mb-4">
            {!! Form::open(['url' => 'commission-auth/login']) !!}
                {!! Form::hidden('redirect', $redirect) !!}
                <div class="form-group">
                    {!! Form::label('username', 'Username') !!}
                    {!! Form::text('username', old('username'), ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group form-check">
                    {!! Form::checkbox('keep_me_signed_in', 1, old('keep_me_signed_in'), ['class' => 'form-check-input', 'id' => 'keep_me_signed_in']) !!}
                    {!! Form::label('keep_me_signed_in', 'Keep me signed in', ['class' => 'form-check-label']) !!}
                </div>
                {!! Form::submit('Sign In', ['class' => 'btn btn-success']) !!}
            {!! Form::close() !!}
        </div>

        <p class="mb-0">Need an account? <a href="{{ url('commission-auth/signup?redirect='.urlencode($redirect ?? '')) }}">Create one here.</a></p>
    @endif
@endsection
