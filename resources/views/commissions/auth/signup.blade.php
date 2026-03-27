@extends('layouts.app')

@section('title')
    Commission Signup
@endsection

@section('content')
    <div class="borderhr mb-4">
        <h1>Create Commission Account</h1>
    </div>

    @if($client)
        <div class="alert alert-success">
            Already signed in as <strong>{{ $client->username }}</strong>.
        </div>
        <a href="{{ url('commission-auth/login') }}" class="btn btn-primary">Go to Login Page</a>
    @else
        <div class="card card-body mb-4">
            {!! Form::open(['url' => 'commission-auth/register']) !!}
                {!! Form::hidden('redirect', $redirect) !!}
                <div class="form-group">
                    {!! Form::label('username', 'Username') !!}
                    {!! Form::text('username', old('username'), ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirm Password') !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
                </div>
                {!! Form::submit('Create Account', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>

        <p class="mb-0">Already have an account? <a href="{{ url('commission-auth/login?redirect='.urlencode($redirect ?? '')) }}">Sign in here.</a></p>
    @endif
@endsection
