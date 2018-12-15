@extends('emails.layouts.notification')

@section('content')

    <tr>
        <td class="header">
            <img src="{{ config('app.url') }}/images/logo.png" />
        </td>
    </tr>

    <!-- Email Body -->
    <tr>
        <td class="body" width="100%" cellpadding="0" cellspacing="0">
            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">

                <!-- Body content -->
                <tr>
                    <td class="content-cell">

                        <p><b>{{ $name }}</b> form has received a new response. Here's the submitted information below.</p>

                        @foreach ($form_response as $key => $value)
                            @if (!is_array($value))
                                <p>{{ str_replace("_", " ", title_case($key)) }}: {{ $value }}</p>
                            @else
                                <p>{{ str_replace("_", " ", title_case($key)) }}:
                                    @foreach($value as $key => $option)
                                        {{ $option.', ' }}
                                    @endforeach
                                </p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection