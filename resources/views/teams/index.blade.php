@extends('layouts.app')

@section("title")
    Team List | @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel brdr-grey-light">
                <div class="panel-body">
                    <team-grid></team-grid>
                </div>
            </div>
        </div>
    </div>
@stop
