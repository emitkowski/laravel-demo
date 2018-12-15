@extends('layouts.app')

@section('title')
    {{$user->name}} | @parent
@endsection

 @section('styles')
    <!--page level css -->
    <link rel="stylesheet" type="text/css" href="/vendors/datatables/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/clear_theme/datatables/custom.css">
    <link rel="stylesheet" type="text/css" href="/css/clear_theme/datatables/datatables_custom.css">
@endsection

@section('page-header')
    <section class="content-header">
        <h1>User Profile</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li>
                <a href="{{ route('users.index') }}">Users</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="panel brdr-grey-light">
                <div class="br3px--tr br3px--tl pt10 pr15 pb10 pl15 bc-grey-lightest brdr1--bottom brdr-grey-light flex jcsb aic">
                    <div class="panel-title tc-grey-darker">
                        <i class="ti-user"></i> User: {{ $user->name }}
                    </div>
                    <div>
                        <a href="{{route('users.edit', [$user->id])}}" class="btn btn-labeled btn-primary ft14 fw4 text-transform-none">
                            <span class="btn-label ft14 fw4">
                                @svg('fa-pencil', 'w12px h12px f-white')
                             </span> 
                            <span>Edit</span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="">
                        <ul class="nav nav-tabs mb15">
                            <li class="nav-item active">
                                <a href="#user-information" data-toggle="tab" class="nav-link">User Information</a>
                            </li>
                            <li class="nav-item">
                                <a href="#user-files" data-toggle="tab" class="nav-link">
                                    <span>@svg('ti-files', 'w14px h14px f-blue')</span>
                                    <span>User Files</span>
                                </a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane active in fade" id="user-information">
                                <div class="ph10">
                                    @include('partials.portal.users.user-info-table')
                                </div>
                            </div>
                            <div class="tab-pane fade" id="user-files">
                                <attachments :type="'user'" :id="{{ $user->id }}"></attachments>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
       
    @include('partials.portal.confirm_approval_modal', ['type' => 'user'])
    @include('partials.portal.confirm_activate_modal', ['type' => 'user'])
    @include('partials.portal.confirm_deactivate_modal', ['type' => 'user'])
    @include('partials.portal.confirm_password_generate_modal', ['type' => 'user'])
    @include('partials.portal.confirm_promote_agent_modal', ['type' => 'user'])

@stop

