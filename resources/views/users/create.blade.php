@extends('layouts.app')

@section('title')Add New User | @parent @endsection

@section('page-header')
    <section class="content-header">
        <h1>Add New User</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li><a href="{{route('users.index')}}">Users</a></li>
            <li class="active">Add New User</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-10">
            <div class="panel brdr-grey-light">
                <div class="br3px--tr br3px--tl pt10 pr15 pb10 pl15 bc-grey-lightest brdr1--bottom brdr-grey-light flex jcsb aic">
                    <div class="panel-title">
                        <i class="ti-user"></i> Add New User
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="{{route('users.store')}}" method="post">
                        {{ csrf_field() }}
                        <div class="mv30 form-group{{ $errors->has('first_name') ? ' has-error has-feedback' : '' }}">
                            <label for="first_name" class="col-sm-2 control-label">@lang('First Name')</label>
                            <div class="col-sm-9">
                                <input 
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    value="{{old('first_name')}}"
                                    placeholder="first name"
                                    class="form-control" required>
                                    @if($errors->has('first_name'))
                                        <span class="help-block">{{$errors->first('first_name')}}</span>
                                    @endif
                            </div>
                        </div>

                        <div class="mv30 form-group{{ $errors->has('last_name') ? ' has-error has-feedback' : '' }}">
                            <label for="last_name" class="col-sm-2 control-label">@lang('Last Name')</label>
                            <div class="col-sm-9">
                                <input 
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    value="{{old('last_name')}}"
                                    placeholder="last name"
                                    class="form-control" required>
                                    @if($errors->has('last_name'))
                                        <span class="help-block">{{$errors->first('last_name')}}</span>
                                    @endif
                            </div>
                        </div>

                        <div class="mv30 form-group{{ $errors->has('email') ? ' has-error has-feedback' : '' }}">
                            <label for="email" class="col-sm-2 control-label">@lang('Email')</label>
                            <div class="col-sm-9">
                                <input 
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{old('email')}}"
                                    placeholder="email"
                                    class="form-control" required>
                                    @if($errors->has('email'))
                                        <span class="help-block">{{$errors->first('email')}}</span>
                                    @endif
                            </div>
                        </div>
                        
                        <div class="mv30 form-group{{ $errors->has('role') ? ' has-error has-feedback' : '' }}">
                            <label for="role" class="col-sm-2 control-label">@lang('Role')</label>
                            <div class="col-sm-9">
                                <select id="role" class="form-control" name="role">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }} @if($role->name == 'user') selected @endif>{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('role'))
                                    <span class="help-block">{{$errors->first('role')}}</span>
                                @endif
                            </div>
                        </div>

                        <div id="user_wrap" class="hidden">
                            <div class="mv30 form-group{{ $errors->has('team') ? ' has-error has-feedback' : '' }}">
                                <label for="team" class="col-sm-2 control-label">{{ ucfirst(Spark::teamString()) }}</label>
                                <div class="col-sm-9">

                                    <select id="team" class="form-control" name="team">
                                        <option value="" {{ old('team') == '' ? 'selected' : '' }}></option>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->id }}" {{ old('team') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('team'))
                                        <span class="help-block">{{$errors->first('team')}}</span>
                                    @endif

                                    <div class="mt15 mb0 alert alert-info">
                                        If the agency does not exist, you will need to <a href="{{ route('agencies.create') }}">create the agency</a> first.
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="license_type" class="col-sm-2 control-label">License Type</label>
                                <div class="col-sm-9">
                                    <div class="iradio">
                                        <label>
                                            <input
                                                type="radio"
                                                name="license_type"
                                                id="license_type_national"
                                                value="national"
                                                {{ old('license_type') == 'national' ? 'checked' : '' }}> National
                                        </label>
                                    </div>
                                    <div class="iradio">
                                        <label>
                                            <input type="radio"
                                                name="license_type"
                                                id="license_type_state"
                                                value="state"
                                                {{ old('license_type') == 'state' ? 'checked' : '' }}> State
                                        </label>
                                    </div>
                                     @if ($errors->has('license_type'))
                                        <span class="help-block"><strong>{{ $errors->first('license_type') }}</strong></span>
                                    @endif
                                </div>
                            </div>


                            <div id="license_type_wrap" class="hidden">
                                <div class="mv30 form-group{{ $errors->has('license_number') ? ' has-error' : '' }}">
                                    <label for="license_number" class="col-sm-2 control-label">License Number</label>
                                    <div class="col-sm-9">
                                        <input
                                            id="license_number"
                                            type="text"
                                            class="form-control"
                                            name="license_number"
                                            placeholder="license number"
                                            value="{{ old('license_number') }}">
                                        @if ($errors->has('license_number'))
                                            <span class="help-block"><strong>{{ $errors->first('license_number') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div id="license_state_wrap" class="hidden">
                                    <div class="mv30 form-group{{ $errors->has('license_state') ? ' has-error' : '' }}">
                                        <label for="license_state" class="col-sm-2 control-label">License State</label>
                                        <div class="col-sm-9">
                                            <select id="license_state" class="form-control" name="license_state">
                                                <option value="" {{ old('license_state') == '' ? 'selected' : '' }}>Select State...</option>
                                                @foreach(CountryState::getStates('US') as $value => $name)
                                                    <option value="{{ $value }}" {{ old('license_state') == $value ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('license_state'))
                                                <span class="help-block"><strong>{{ $errors->first('license_state') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mv30">
                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-9">
                                    <div class="flex aic">
                                        <button type="submit" class="btn btn-primary mb0 mr25 ft14 fw4 text-transform-none">Submit</button>
                                        <a href="{{route('users.index')}}" class="tc-grey">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_scripts')
    <script src="{{ mix('js/users.js') }}"></script>
@endsection