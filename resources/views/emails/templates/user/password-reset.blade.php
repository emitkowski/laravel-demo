@extends('emails.layouts.notification')

@section('content')
    <p>Hello!</p>

    <p>You are receiving this email because we received a password reset request for your account.</p>

    <p><a href="{{ $reset_url }}">{{ $reset_url }}</a></p>

    <p>If you did not request a password reset, no further action is required.</p>

    <p><b>{{ config('app.name') }}</b></p>
@endsection