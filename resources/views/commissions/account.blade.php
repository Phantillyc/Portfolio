@extends('layouts.app')

@section('title')
    Commission Account
@endsection

@section('content')
    <div class="borderhr mb-4">
        <h1>Commission Account</h1>
    </div>

    <p>This lightweight account is only used to access and request commissions.</p>

    @if ($commissioner)
        <div class="alert alert-success">Signed in as <strong>{{ $commissioner->username }}</strong>.</div>
        {!! Form::open(['url' => 'commissions/account/logout']) !!}
            {!! Form::hidden('redirect', $redirect) !!}
            {!! Form::submit('Sign Out', ['class' => 'btn btn-secondary']) !!}
        {!! Form::close() !!}
    @else
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card card-body">
                    <h3>Create Account</h3>
                    {!! Form::open(['url' => 'commissions/account/register']) !!}
                        {!! Form::hidden('redirect', $redirect) !!}
                        <div class="form-group">{!! Form::label('username', 'Username') !!}{!! Form::text('username', null, ['class' => 'form-control']) !!}</div>
                        <div class="form-group">{!! Form::label('email', 'Email') !!}{!! Form::email('email', null, ['class' => 'form-control']) !!}</div>
                        <div class="form-group">{!! Form::label('name', 'Display Name') !!}{!! Form::text('name', null, ['class' => 'form-control']) !!}</div>
                        <div class="form-group">{!! Form::label('password', 'Password') !!}{!! Form::password('password', ['class' => 'form-control']) !!}</div>
                        <div class="form-group">{!! Form::label('password_confirmation', 'Confirm Password') !!}{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}</div>
                        {!! Form::submit('Create Account', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card card-body">
                    <h3>Sign In</h3>
                    {!! Form::open(['url' => 'commissions/account/login']) !!}
                        {!! Form::hidden('redirect', $redirect) !!}
                        <div class="form-group">{!! Form::label('username', 'Username') !!}{!! Form::text('username', null, ['class' => 'form-control']) !!}</div>
                        <div class="form-group">{!! Form::label('password', 'Password') !!}{!! Form::password('password', ['class' => 'form-control']) !!}</div>
                        {!! Form::submit('Sign In', ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif
@endsection
