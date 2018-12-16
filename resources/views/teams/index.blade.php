@extends('layouts.app')

@section("title")
    Team List | @parent
@endsection

 @section('styles')
    <!--page level css -->
    <link rel="stylesheet" type="text/css" href="/vendors/datatables/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/clear_theme/datatables/custom.css">
    <link rel="stylesheet" type="text/css" href="/css/clear_theme/datatables/datatables_custom.css">
@endsection

@section('page-header')
    <section class="content-header">
        <h1>Team List</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li>Teams</li>
            <li class="active">
                Team List
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
                        <i class="fa fa-fw ti-menu-alt"></i> Team List
                    </div>
                </div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_scripts')
    <script type="text/javascript" src="{{asset('vendors/datatables/js/jquery.dataTables.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/custom_js/datatables.js')}}"></script>
@stop
