@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card mrgn_btm">
                <div class="card-header">
                    <h3 class="card-title">
                        Manage Teams
                    </h3>
                </div>
                <div class="card-body">
                    <p><a href="{{ route('teams.index') }}">Mange My Teams</a></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card mrgn_btm">
                <div class="card-header">
                    <h3 class="card-title">
                        Manage Players
                    </h3>
                </div>
                <div class="card-body">
                    <p><a href="{{ route('players.index') }}">Mange My Players</a></p>
                </div>
            </div>
        </div>

    </div>
@endsection
