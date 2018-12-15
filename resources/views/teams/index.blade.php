@extends('layouts.app')

@section("title")
    {{ ucfirst(Spark::$teamString) }} List | @parent
@endsection

 @section('styles')
    <!--page level css -->
    <link rel="stylesheet" type="text/css" href="/vendors/datatables/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/clear_theme/datatables/custom.css">
    <link rel="stylesheet" type="text/css" href="/css/clear_theme/datatables/datatables_custom.css">
@endsection

@section('page-header')
    <section class="content-header">
        <h1>{{ ucfirst(Spark::$teamString) }} List</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li>{{ ucfirst(str_plural(Spark::$teamString)) }}</li>
            <li class="active">
                {{ ucfirst(Spark::$teamString) }} List
            </li>
        </ol>
    </section>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel brdr-grey-light">
                <div class="panel-heading bc-grey-lightest brdr1--bottom brdr-grey-light">
                    <div class="panel-title tc-grey-darker">
                        <i class="fa fa-fw ti-menu-alt"></i> {{ ucfirst(Spark::$teamString) }} List
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover fw4" id="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td>
                                        <a href="{{route(str_plural(Spark::teamString()).'.show',[$team->id])}}">
                                            @svg('fa-eye', 'w12px h12px f-grey-light mr5')
                                            <span>{{$team->name}}</span>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $team->owner->name ?? '' }}
                                        <span class="ml5 tc-grey">-- {{ $team->owner->email ?? '' }}</span>
                                        
                                    </td>
                                    <td data-order="{{ $team->created_at }}">
                                        {{ $team->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="flex jcsb ffrw">
                                            @if($team->status_display === 'Active')
                                                <div>
                                                    <span>
                                                        @svg('fa-check', 'w10px h10px f-green-dark')
                                                    </span>
                                                    <span class="mr10 ft12 fw7 tc-green-dark">
                                                        {{ $team->status_display }}
                                                    </span>
                                                </div>
                                                <form action="{{route(str_plural(Spark::teamString()).'.deactivate', [$team->id])}}" method="post" class="form-inline" style="display: inline-block" data-toggle="modal" data-confirm='#deactivate'>
                                                    {{csrf_field()}}
                                                    {{method_field('put')}}
                                                    <button class="brdr-none bc-transparent tc-red-light ft12" aria-label="Deactivate" title="Deactivate" type="submit">
                                                        (deactivate)
                                                    </button>
                                                </form>
                                            @else
                                                <div>
                                                    <span>
                                                        @svg('fa-times', 'w10px h10px f-grey-dark')
                                                    </span>
                                                    <span class="mr10 ft12 tc-grey-darker">
                                                        {{ $team->status_display }}
                                                    </span>
                                                </div>
                                                <form action="{{route(str_plural(Spark::teamString()).'.activate', [$team->id])}}" method="post" class="form-inline" style="display: inline-block" data-toggle="modal" data-confirm='#activate'>
                                                    {{csrf_field()}}
                                                    {{method_field('put')}}
                                                    <button class="brdr-none bc-transparent tc-grey ft12" aria-label="Activate" title="Activate" type="submit">
                                                        (activate)
                                                    </button>
                                                </form>
                                            @endif
                                            {{--<form action="{{route(str_plural(Spark::teamString()).'.destroy', [$team->id])}}" method="post" class="form-inline" style="display: inline-block" data-toggle="modal" data-confirm='#delete'>--}}
                                                {{--{{csrf_field()}}--}}
                                                {{--{{method_field('delete')}}--}}
                                                {{--<button class="btn btn-danger" aria-label="Delete" title="Delete" type="submit">Delete</button>--}}
                                            {{--</form>--}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{--<a href="{{route(str_plural(Spark::teamString()).'.create')}}" class="btn btn-primary">Add New {{ ucfirst(Spark::$teamString) }}</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.portal.confirm_delete_modal', ['type' => Spark::$teamString ])
    @include('partials.portal.confirm_activate_modal', ['type' => Spark::$teamString ])
    @include('partials.portal.confirm_deactivate_modal', ['type' => Spark::$teamString ])
@stop

@section('footer_scripts')
    <script type="text/javascript" src="{{asset('vendors/datatables/js/jquery.dataTables.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/custom_js/datatables.js')}}"></script>
@stop
