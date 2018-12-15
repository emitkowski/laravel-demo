@extends('layouts.app')

@section("title")
    User List | @parent
@endsection

 @section('styles')
    <!--page level css -->
    <link rel="stylesheet" type="text/css" href="/vendors/datatables/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/clear_theme/datatables/custom.css">
    <link rel="stylesheet" type="text/css" href="/css/clear_theme/datatables/datatables_custom.css">
@endsection

@section('page-header')
    <section class="content-header">
        <h1>Users List</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li class="active">
                Users
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
                        <i class="fa fa-fw ti-menu-alt"></i> Users List
                    </div>
                </div>
                <div class="panel-body">
                    <div id="netrate-show" class="btn btn-primary">Show NetRate Passwords</div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover fw4" id="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th class="netrate-password-column">NetRate Password</th>
                                <th>E-mail</th>
                                <th>Role</th>
                                <th>Agency</th>
                                <th>Last Login</th>
                                <th>Created</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($users)
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <a href="{{route('users.show',[$user->id])}}">
                                                    @svg('fa-eye', 'w12px h12px f-grey-light mr5')
                                                    <span>{{$user->first_name}} {{$user->last_name}}</span>
                                                </a>
                                            </td>
                                            <td class="netrate-password-column">{{(!is_null( $user->netrate_password) ? $user->netrate_password : 'N/A')}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->role_display}}</td>
                                            <td>{{(!is_null($user->currentTeam) ? $user->currentTeam->name : 'N/A')}}</td>
                                            <td data-order="{{ (!is_null($user->last_login) ? $user->last_login : 'Never') }}">
                                                {{ (!is_null($user->last_login) ? $user->last_login->diffForHumans() : 'Never') }}
                                            </td>
                                            <td data-order="{{ $user->created_at }}">
                                                {{ $user->created_at->diffForHumans() }}
                                            </td>
                                            <td>
                                                <div class="flex jcsb ffrw">
                                                    @if($user->pending == 'Pending Approval')
                                                        <div>
                                                            <span>
                                                                @svg('fa-spinner', 'w10px h10px f-grey-dark')
                                                            </span>
                                                            <span class="mr10 ft12 tc-grey-darker">
                                                                Pending
                                                            </span>
                                                        </div>
                                                        <form action="{{route('users.approve', [$user->id])}}" method="post" class="form-inline" style="display: inline-block" data-toggle="modal" data-confirm='#approve'>
                                                            {{csrf_field()}}
                                                            {{method_field('put')}}
                                                            <button class="brdr-none bc-transparent tc-blue-light ft12" aria-label="Approve" title="Approve" type="submit">
                                                                (approve)
                                                            </button>
                                                        </form>
                                                    @elseif($user->pending == 'Active')
                                                        <div>
                                                            <span>
                                                                @svg('fa-check', 'w10px h10px f-green-dark')
                                                            </span>
                                                            <span class="mr10 ft12 fw7 tc-green-dark">
                                                                {{$user->pending}}
                                                            </span>
                                                        </div>
                                                        <form action="{{route('users.deactivate', [$user->id])}}" method="post" class="form-inline" style="display: inline-block" data-toggle="modal" data-confirm='#deactivate'>
                                                            {{csrf_field()}}
                                                            {{method_field('put')}}
                                                            <button class="brdr-none bc-transparent tc-red-light ft12" aria-label="Deactivate" title="Deactivate" type="submit">
                                                                (deactivate)
                                                            </button>
                                                        </form>
                                                    @elseif($user->pending == 'Inactive')
                                                        <div>
                                                            <span>
                                                                @svg('fa-times', 'w10px h10px f-grey-dark')
                                                            </span>
                                                            <span class="mr10 ft12 tc-grey-darker">
                                                                {{$user->pending}}
                                                            </span>
                                                        </div>
                                                        <form action="{{route('users.activate', [$user->id])}}" method="post" class="form-inline" style="display: inline-block" data-toggle="modal" data-confirm='#activate'>
                                                            {{csrf_field()}}
                                                            {{method_field('put')}}
                                                            <button class="brdr-none bc-transparent tc-grey ft12" aria-label="Activate" title="Activate" type="submit">
                                                                (activate)
                                                            </button>
                                                        </form>
                                                    @endif
                                                    {{--<form action="{{route('users.destroy', [$user->id])}}" method="post"--}}
                                                          {{--class="form-inline" style="display: inline-block" data-toggle="modal"--}}
                                                          {{--data-confirm='#delete'>--}}
                                                        {{--{{csrf_field()}}--}}
                                                        {{--{{method_field('delete')}}--}}
                                                        {{--<button class="btn btn-danger" aria-label="Delete" title="Delete"--}}
                                                                {{--type="submit">--}}
                                                            {{--Delete--}}
                                                        {{--</button>--}}
                                                    {{--</form>--}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <a href="{{route('users.create')}}" class="btn btn-primary">Add New User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.portal.confirm_delete_modal', ['type' => 'user'])
    @include('partials.portal.confirm_activate_modal', ['type' => 'user'])
    @include('partials.portal.confirm_approval_modal', ['type' => 'user'])
    @include('partials.portal.confirm_deactivate_modal', ['type' => 'user'])

@stop

@section('footer_scripts')
    <script type="text/javascript" src="{{asset('vendors/datatables/js/jquery.dataTables.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/custom_js/datatables.js')}}"></script>
@stop
