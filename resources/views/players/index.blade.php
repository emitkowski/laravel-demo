@extends('layouts.app')

@section("title")
    Player List | @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel brdr-grey-light">
                <div class="panel-body">
                    <player-grid></player-grid>
                </div>
            </div>
        </div>
    </div>
@stop
