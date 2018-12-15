@extends('layouts.app')

@section('title')
    Edit User | @parent
@endsection

@section('page-header')
    <section class="content-header">
        <h1>Edit User</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li><a href="{{ route('users.index') }}">Users</a></li>
            <li><a href="{{ route('users.show', ['id'=> $user->id]) }}">Profile</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-10">
            <attachments
                :type="'user'"
                :id="{{ $user->id }}"
                :name='"{{ $user->name }}"'>
            </attachments>
            <div class="panel brdr-grey-light">
                <div class="br3px--tr br3px--tl pt10 pr15 pb10 pl15 bc-grey-lightest brdr1--bottom brdr-grey-light flex jcsb aic">
                    <div class="panel-title">
                        <i class="ti-user"></i> Edit User: {{ $user->name }}
                    </div>
                </div>
                <div class="panel-body">

                    <form class="form-horizontal" role="form" action="{{route('users.update', [$user->id])}}" method="post">
                        {{ method_field('put') }}
                        {{ csrf_field() }}

                        <div class="mv30 form-group{{ $errors->has('first_name') ? ' has-error has-feedback' : '' }}">
                            <label for="first_name" class="col-sm-2 control-label">@lang('First Name')</label>
                            <div class="col-sm-9">
                                <input 
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    value="{{ old('first_name', $user->first_name) }}"
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
                                    value="{{old('last_name', $user->last_name)}}"
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
                                    value="{{old('email', $user->email)}}"
                                    placeholder="email"
                                    class="form-control" required>
                                    @if($errors->has('email'))
                                        <span class="help-block">{{$errors->first('email')}}</span>
                                    @endif
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
                                            {{ old('license_type') == 'national' || !$user->license_state  ? 'checked' : '' }}> National
                                    </label>
                                </div>
                                <div class="iradio">
                                    <label>
                                        <input type="radio"
                                            name="license_type"
                                            id="license_type_state"
                                            value="state"
                                            {{ old('license_type') == 'state' || $user->license_state ? 'checked' : '' }}> State
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
                                        value="{{ old('license_number', $user->license_number) }}">
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
                                                <option value="{{ $value }}" {{ old('license_state', $user->license_state) == $value ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('license_state'))
                                            <span class="help-block"><strong>{{ $errors->first('license_state') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" mv30">
                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-9">
                                    <h3>Change Password</h3>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="mv30 form-group{{ $errors->has('password') ? ' has-error has-feedback' : '' }}">
                            <label for="password" class="col-sm-2 control-label">@lang('Password')</label>
                            <div class="col-sm-9">
                                <input 
                                    type="password"
                                    id="password"
                                    name="password"
                                    value="{{old('password')}}"
                                    placeholder="password"
                                    class="form-control">
                                    @if($errors->has('password'))
                                        <span class="help-block">{{$errors->first('password')}}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="mv30 form-group{{ $errors->has('password_confirmation') ? ' has-error has-feedback' : '' }}">
                            <label for="password_confirmation" class="col-sm-2 control-label">@lang('Confirm Password')</label>
                            <div class="col-sm-9">
                                <input 
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    value=""
                                    placeholder="password confirmation"
                                    class="form-control">
                                    @if($errors->has('password_confirmation'))
                                        <span class="help-block">{{$errors->first('password_confirmation')}}</span>
                                    @endif
                            </div>
                        </div>
                        
                        <div class="mv30">
                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-9">
                                    <div class="flex aic">
                                        <button type="submit" class="btn btn-primary mb0 mr25">Submit</button>
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