@extends('layouts.app')

@section('title')
    Add New {{ ucfirst(Spark::$teamString) }} | @parent
@endsection

@section('page-header')
    <section class="content-header">
        <h1>Add New {{ ucfirst(Spark::$teamString) }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li>{{ ucfirst(str_plural(Spark::$teamString)) }}</li>
            <li class="active">
                Add New {{ ucfirst(Spark::$teamString) }}
            </li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-10">
            <div class="panel brdr-grey-light">
                <div class="br3px--tr br3px--tl pt10 pr15 pb10 pl15 bc-grey-lightest brdr1--bottom brdr-grey-light flex jcsb aic">
                    <div class="panel-title">
                        <i class="fa fa-user-plus"></i> Add New {{ ucfirst(Spark::$teamString) }}
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="{{ route(str_plural(Spark::teamString()).'.store') }}" method="post">
                        {{ csrf_field() }}

                        <h3 class="text-center">Agent Information</h3>

                        <!-- First Name -->
                        <div class="mv30 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-sm-2 control-label">First Name</label>

                            <div class="col-sm-9">
                                <input
                                    id="first_name"
                                    type="text"
                                    class="form-control"
                                    name="first_name"
                                    value="{{ old('first_name') }}" autofocus required>
                                @if ($errors->has('first_name'))
                                    <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="mv30 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-sm-2 control-label">Last Name</label>

                            <div class="col-sm-9">
                                <input
                                    id="last_name"
                                    type="text"
                                    class="form-control"
                                    name="last_name"
                                    value="{{ old('last_name') }}" required>
                                @if ($errors->has('last_name'))
                                    <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mv30 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-sm-2 control-label">Email Address</label>

                            <div class="col-sm-9">
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="mv30 form-group{{ $errors->has('license_type') ? ' has-error' : '' }}">
                            <label for="license_type" class="col-sm-2 control-label">Choose one of the license number types for verification:</label>
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
                                        <input
                                            type="radio"
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

                            <!-- License Number -->
                            <div class="mv30 form-group{{ $errors->has('license_number') ? ' has-error' : '' }}">
                                <label for="license_number" class="col-sm-2 control-label">License Number</label>

                                <div class="col-sm-9">
                                    <input id="license_number" type="text" class="form-control" name="license_number" value="{{ old('license_number') }}">

                                    @if ($errors->has('license_number'))
                                        <span class="help-block"><strong>{{ $errors->first('license_number') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <div id="license_state_wrap" class="hidden">

                                <!-- License State -->
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

                        <hr>
                        
                        <h3 class="text-center mt50">Agency Information</h3>
                        
                        <!-- Agency Name -->
                        <div class="mv30 form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                            <label for="name" class="col-sm-2 control-label">Agency Name</label>
                            <div class="col-sm-9">
                                <input 
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Agency name"
                                    class="form-control" required>
                                    @if($errors->has('name'))
                                        <span class="help-block">{{$errors->first('name')}}</span>
                                    @endif
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="mv30 form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-sm-2 control-label">Phone Number</label>

                            <div class="col-sm-9">
                                <input
                                    id="phone"
                                    type="text"
                                    class="form-control"
                                    name="phone"
                                    value="{{ old('phone') }}" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="mv30 form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                            <label for="website" class="col-sm-2 control-label">Website</label>

                            <div class="col-sm-9">
                                <input
                                    id="website"
                                    type="text"
                                    class="form-control"
                                    name="website"
                                    value="{{ old('website') }}" required>

                                @if ($errors->has('website'))
                                    <span class="help-block"><strong>{{ $errors->first('website') }}</strong></span>
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
                                            {{ old('type') == 'Retail' ? 'checked' : '' }}> Retail
                                    </label>
                                </div>
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="type"
                                            id="type2"
                                            value="Wholesale"
                                            {{ old('type') == 'Wholesale' ? 'checked' : '' }}> Wholesale
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
                                            {{ old('business_type') == 'Sole Proprietorship' ? 'checked' : '' }}> Sole Proprietorship
                                    </label>
                                </div>
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="business_type"
                                            id="business_type2"
                                            value="Corporation"
                                            {{ old('business_type') == 'Corporation' ? 'checked' : '' }}> Corporation
                                    </label>
                                </div>
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="business_type"
                                            id="business_type3"
                                            value="Partnership"
                                            {{ old('business_type') == 'Partnership' ? 'checked' : '' }}> Partnership
                                    </label>
                                </div>
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="business_type"
                                            id="business_type4"
                                            value="LLC"
                                            {{ old('business_type') == 'LLC' ? 'checked' : '' }}> LLC
                                    </label>
                                </div>
                                
                                 @if ($errors->has('business_type'))
                                    <span class="help-block"><strong>{{ $errors->first('business_type') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <h3 class="text-center">Agency Physical Address</h3>

                        <!-- Address -->
                        <div class="mv30 form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-sm-2 control-label">Address</label>

                            <div class="col-sm-9">
                                <input
                                    id="address"
                                    type="text"
                                    class="form-control"
                                    name="address"
                                    value="{{ old('address') }}" required>

                                @if ($errors->has('address'))
                                    <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <!-- Address 2 -->
                        <div class="mv30 form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                            <label for="address2" class="col-sm-2 control-label">Address 2</label>

                            <div class="col-sm-9">
                                <input
                                    id="address2"
                                    type="text"
                                    class="form-control"
                                    name="address2"
                                    value="{{ old('address2') }}">

                                @if ($errors->has('address2'))
                                    <span class="help-block"><strong>{{ $errors->first('address2') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <!-- City -->
                        <div class="mv30 form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city" class="col-sm-2 control-label">City</label>

                            <div class="col-sm-9">
                                <input
                                    id="city"
                                    type="text"
                                    class="form-control"
                                    name="city"
                                    value="{{ old('city') }}" required>

                                @if ($errors->has('city'))
                                    <span class="help-block"><strong>{{ $errors->first('city') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <!-- State -->
                        <div class="mv30 form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                            <label for="state" class="col-sm-2 control-label">State</label>

                            <div class="col-sm-9">
                                <select id="state" class="form-control" name="state" required>
                                    <option value="" {{ old('state') == '' ? 'selected' : '' }}>Select State...</option>
                                    @foreach(CountryState::getStates('US') as $value => $name)
                                        <option value="{{ $value }}" {{ old('state') == $value ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('state'))
                                    <span class="help-block"><strong>{{ $errors->first('state') }}</strong></span>
                                @endif
                            </div>
                        </div>


                        <!-- Zip -->
                        <div class="mv30 form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                            <label for="zip" class="col-sm-2 control-label">Zip Code</label>

                            <div class="col-sm-9">
                                <input
                                    id="zip"
                                    type="text"
                                    class="form-control"
                                    name="zip"
                                    value="{{ old('zip') }}" required>

                                @if ($errors->has('zip'))
                                    <span class="help-block"><strong>{{ $errors->first('zip') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <!-- Mailing address different? -->
                        <div class="mv30 form-group{{ $errors->has('diff_addr') ? ' has-error' : '' }}">
                            <label for="diff_addr" class="col-sm-2 control-label">Is your mailing address different than above?</label>
                            <div class="col-sm-9">
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="diff_addr"
                                            id="diff_addr_yes"
                                            value="yes"
                                            {{ old('diff_addr') == 'yes' ? 'checked' : '' }}> Yes
                                    </label>
                                </div>
                                <div class="iradio">
                                    <label>
                                        <input
                                            type="radio"
                                            name="diff_addr"
                                            id="diff_addr_yes"
                                            value="no"
                                            {{ old('diff_addr') == 'no' ? 'checked' : '' }}> No
                                    </label>
                                </div>

                                @if ($errors->has('diff_addr'))
                                    <span class="help-block"><strong>{{ $errors->first('diff_addr') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div id="diff_address_wrap" class="hidden">
                                
                            <h3 class="text-center">Agency Mailing Address</h3>

                            <!-- Address 1 (mailing) -->
                            <div class="mv30 form-group{{ $errors->has('mailing_address') ? ' has-error' : '' }}">
                                <label for="mailing_address" class="col-sm-2 control-label">Address</label>

                                <div class="col-sm-9">
                                    <input
                                        id="mailing_address"
                                        type="text"
                                        class="form-control"
                                        name="mailing_address"
                                        value="{{ old('mailing_address') }}">

                                    @if ($errors->has('mailing_address'))
                                        <span class="help-block"><strong>{{ $errors->first('mailing_address') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!-- Address 2 (mailing) -->
                            <div class="mv30 form-group{{ $errors->has('mailing_address2') ? ' has-error' : '' }}">
                                <label for="mailing_address2" class="col-sm-2 control-label">Address 2</label>

                                <div class="col-sm-9">
                                    <input
                                        id="mailing_address2"
                                        type="text"
                                        class="form-control"
                                        name="mailing_address2"
                                        value="{{ old('mailing_address2') }}">

                                    @if ($errors->has('mailing_address2'))
                                        <span class="help-block"><strong>{{ $errors->first('mailing_address2') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!-- City (mailing) -->
                            <div class="mv30 form-group{{ $errors->has('mailing_city') ? ' has-error' : '' }}">
                                <label for="mailing_city" class="col-sm-2 control-label">City</label>

                                <div class="col-sm-9">
                                    <input
                                        id="mailing_city"
                                        type="text"
                                        class="form-control"
                                        name="mailing_city"
                                        value="{{ old('mailing_city') }}">

                                    @if ($errors->has('mailing_city'))
                                        <span class="help-block"><strong>{{ $errors->first('mailing_city') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!-- State (mailing) -->
                            <div class="mv30 form-group{{ $errors->has('mailing_state') ? ' has-error' : '' }}">
                                <label for="mailing_state" class="col-sm-2 control-label">State</label>

                                <div class="col-sm-9">
                                    <select id="mailing_state" class="form-control" name="mailing_state">
                                        <option value="" {{ old('mailing_state') == '' ? 'selected' : '' }}>Select State...</option>
                                        @foreach(CountryState::getStates('US') as $value => $name)
                                            <option value="{{ $value }}" {{ old('mailing_state') == $value ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('mailing_state'))
                                        <span class="help-block"><strong>{{ $errors->first('mailing_state') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!-- Zip (mailing) -->
                            <div class="mv30 form-group{{ $errors->has('mailing_zip') ? ' has-error' : '' }}">
                                <label for="mailing_zip" class="col-sm-2 control-label">Zip Code</label>

                                <div class="col-sm-9">
                                    <input
                                        id="mailing_zip"
                                        type="text"
                                        class="form-control"
                                        name="mailing_zip"
                                        value="{{ old('mailing_zip') }}">

                                    @if ($errors->has('mailing_zip'))
                                        <span class="help-block"><strong>{{ $errors->first('mailing_zip') }}</strong></span>
                                    @endif
                                </div>
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
                                    value="{{ old('error_omission_policy_number') }}"
                                    placeholder="policy number"
                                    class="form-control" required>
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
                                    value="{{ old('error_omission_carrier_name') }}"
                                    placeholder="carrier name"
                                    class="form-control" required>
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
                                    value="{{ old('error_omission_exp_date') }}"
                                    placeholder="mm/dd/yyyy"
                                    class="form-control"
                                    autocomplete="off" required>
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
    <script src="{{ mix('js/register-agency.js') }}"></script>
@endsection