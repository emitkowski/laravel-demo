@extends('layouts.app')

@section('title')
    Edit {{ ucfirst(Spark::$teamString) }} | @parent
@endsection

@section('page-header')
    <section class="content-header">
        <h1>Edit {{ ucfirst(Spark::$teamString) }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li>
                <a href="{{ route(str_plural(Spark::teamString()).'.index') }}">{{ ucfirst(str_plural(Spark::$teamString)) }}</a>
            </li>
            <li>
                <a href="{{ route(str_plural(Spark::teamString()).'.show',[$team->id]) }}">Agency Profile</a>
            </li>
            <li class="active">Edit</li>
        </ol>
    </section>
@stop

@section('content')
    
    <div class="row">
        <div class="col-md-12 col-lg-10">
            <addresses :type="'team'" :id="{{ $team->id }}" :name='"{{ $team->name }}"'></addresses>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-10">
            <div class="panel brdr-grey-light">
                <div class="br3px--tr br3px--tl pt10 pr15 pb10 pl15 bc-grey-lightest brdr1--bottom brdr-grey-light flex jcsb aic">
                    <div class="panel-title">
                        <i class="fa fa-users"></i> Edit {{ ucfirst(Spark::$teamString) }}: {{ $team->name }}
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="{{route(str_plural(Spark::teamString()).'.update', [$team->id])}}" method="post">
                        {{ method_field('put') }}
                        {{ csrf_field() }}

                        <div class="mv30 form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                            <label for="name" class="col-sm-2 control-label">@lang('Name')</label>
                            <div class="col-sm-9">
                                <input 
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{old('name', $team->name)}}"
                                    placeholder="first name"
                                    class="form-control" required>
                                    @if($errors->has('name'))
                                        <span class="help-block">{{$errors->first('name')}}</span>
                                    @endif
                            </div>
                        </div>

                        <!-- Agency Type -->
                        <div class="mv30 form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="license_type" class="col-sm-2 control-label">Agency Type</label>
                            <div class="col-sm-9">
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="type"
                                            id="type1"
                                            value="Retail"
                                            {{ old('type', $team->type) == 'Retail' ? 'checked' : '' }}> Retail
                                    </label>
                                </div>
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="type"
                                            id="type2"
                                            value="Wholesale"
                                            {{ old('type', $team->type) == 'Wholesale' ? 'checked' : '' }}> Wholesale
                                    </label>
                                </div>
                                 @if ($errors->has('type'))
                                    <span class="help-block"><strong>{{ $errors->first('type') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Agency Business Type -->
                        <div class="mv30 form-group{{ $errors->has('business_type') ? ' has-error' : '' }}">
                            <label for="business_type" class="col-sm-2 control-label">Agency Business Type</label>
                            <div class="col-sm-9">
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="business_type"
                                            id="business_type1"
                                            value="Sole Proprietorship"
                                            {{ old('business_type', $team->business_type) == 'Sole Proprietorship' ? 'checked' : '' }}> Sole Proprietorship
                                    </label>
                                </div>
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="business_type"
                                            id="business_type2"
                                            value="Corporation"
                                            {{ old('business_type', $team->business_type) == 'Corporation' ? 'checked' : '' }}> Corporation
                                    </label>
                                </div>
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="business_type"
                                            id="business_type3"
                                            value="Partnership"
                                            {{ old('business_type', $team->business_type) == 'Partnership' ? 'checked' : '' }}> Partnership
                                    </label>
                                </div>
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="business_type"
                                            id="business_type4"
                                            value="LLC"
                                            {{ old('business_type', $team->business_type) == 'LLC' ? 'checked' : '' }}> LLC
                                    </label>
                                </div>
                                
                                 @if ($errors->has('business_type'))
                                    <span class="help-block"><strong>{{ $errors->first('business_type') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <hr>
                        <h3 class="text-center">Errors and Omissions Policy Information</h3>
                        <br>
                        
                        <!-- Policy Number-->
                        <div class="mv30 form-group{{ $errors->has('error_omission_policy_number') ? ' has-error has-feedback' : '' }}">
                            <label for="error_omission_policy_number" class="col-sm-2 control-label">@lang('Policy Number')</label>
                            <div class="col-sm-9">
                                <input 
                                    type="text"
                                    id="error_omission_policy_number"
                                    name="error_omission_policy_number"
                                    value="{{old('error_omission_policy_number', $team->error_omission_policy_number)}}"
                                    placeholder="policy number"
                                    class="form-control">
                                    @if($errors->has('error_omission_policy_number'))
                                        <span class="help-block">{{$errors->first('error_omission_policy_number')}}</span>
                                    @endif
                            </div>
                        </div>
                        
                        <!-- Policy Carrier Name -->
                        <div class="mv30 form-group{{ $errors->has('error_omission_carrier_name') ? ' has-error has-feedback' : '' }}">
                            <label for="error_omission_carrier_name" class="col-sm-2 control-label">@lang('Carrier Name')</label>
                            <div class="col-sm-9">
                                <input 
                                    type="text"
                                    id="error_omission_carrier_name"
                                    name="error_omission_carrier_name"
                                    value="{{old('error_omission_carrier_name', $team->error_omission_carrier_name)}}"
                                    placeholder="carrier name"
                                    class="form-control">
                                    @if($errors->has('error_omission_carrier_name'))
                                        <span class="help-block">{{$errors->first('error_omission_carrier_name')}}</span>
                                    @endif
                            </div>
                        </div>
                        
                        <!-- Policy Expiration Date -->
                        <div class="mv30 form-group{{ $errors->has('error_omission_exp_date') ? ' has-error has-feedback' : '' }}">
                            <label for="error_omission_exp_date" class="col-sm-2 control-label">@lang('Expiration Date')</label>
                            <div class="col-sm-9">
                                <input 
                                    type="text"
                                    id="error_omission_exp_date"
                                    name="error_omission_exp_date"
                                    value="{{ old('error_omission_exp_date', (!is_null($team->error_omission_exp_date) ? $team->error_omission_exp_date ->format('m/d/Y') : '')) }}"
                                    placeholder="mm/dd/yyyy"
                                    class="form-control"
                                    autocomplete="off">
                                    @if($errors->has('error_omission_exp_date'))
                                        <span class="help-block">{{$errors->first('error_omission_exp_date')}}</span>
                                    @endif
                            </div>
                        </div>

                        <div class="mv30">
                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-9">
                                    <div class="flex aic">
                                        <button type="submit" class="btn btn-primary mb0 mr25">Submit</button>
                                        <a href="{{route(str_plural(Spark::teamString()).'.index')}}" class="tc-grey">Cancel</a>
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