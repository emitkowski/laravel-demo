@extends('layouts.app')

@section('title')
    {{$team->name}} Profile | @parent
@endsection

@section('page-header')
    <section class="content-header">
        <h1>{{ ucfirst(Spark::$teamString) }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li>
                <a href="{{ route(str_plural(Spark::teamString()).'.index') }}">{{ ucfirst(str_plural(Spark::$teamString)) }}</a>
            </li>
            <li class="active">
                {{ ucfirst(Spark::$teamString) }} Profile
            </li>
        </ol>
    </section>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="panel brdr-grey-light">
                <div class="br3px--tr br3px--tl pt10 pr15 pb10 pl15 bc-grey-lightest brdr1--bottom brdr-grey-light flex jcsb aic">
                    <div class="panel-title tc-grey-darker">
                        <i class="fa fa-users"></i> {{ ucfirst(Spark::$teamString) }}: {{ $team->name }}
                    </div>
                    <div>
                        <a href="{{route(str_plural(Spark::teamString()).'.edit',[$team->id])}}" class="btn btn-labeled btn-primary ft14 fw4 text-transform-none">
                            <span class="btn-label">
                                @svg('fa-pencil', 'w12px h12px f-white')
                             </span> 
                            <span>Edit</span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th class="brdr-none">Name</th>
                                <td class="brdr-none">{{$team->name}}</td>
                            </tr>
                            <tr>
                                <th>Owner</th>
                                <td>{{ ($team->owner ? $team->owner->name .'( '.$team->owner->email.')' : '') }}</td>
                            </tr>
                            <tr>
                                <th>Agency Type</th>
                                <td>{{$team->type}}</td>
                            </tr>
                            <tr>
                                <th>Business Type</th>
                                <td>{{$team->business_type}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{$team->phone}}</td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>{{$team->website}}</td>
                            </tr>
                            <tr>
                                <th>Account Created</th>
                                <td>{{$team->created_at->format('m/d/Y g:i:s a')}} <b>({{ $team->created_at->diffForHumans() }})</b>
                                </td>
                            </tr>
                        </table>
                        <h3 class="text-center">Errors and Omissions Policy Information</h3>
                        <table class="table">
                            <tr>
                                <th>Policy Number</th>
                                <td>{{$team->error_omission_policy_number}}</td>
                            </tr>
                            <tr>
                                <th>Carrier Name</th>
                                <td>{{$team->error_omission_carrier_name}}</td>
                            </tr>
                            <tr>
                                <th>Expiration Date</th>
                                <td>{{ ($team->error_omission_exp_date ? $team->error_omission_exp_date->format('m/d/Y') : '') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

