@extends('emails.layouts.notification')

@section('content')

    <p>A new file has been uploaded to the portal.</p>

    <p>Uploaded By: {{ optional($attachment->model)->name}}</p>
    <p>Uploaded At: {{ $attachment->created_at->format('m/d/Y g:i:s a') }}</p>
    <p>File Name: {{ $attachment->filename }}</p>
    <p>
        <a href="{{ $attachment->getTemporaryUrl(\Carbon\Carbon::now()->addDays(30)) }}">
            <button class="button button-blue">Download File</button>
        </a>
    </p>

@endsection