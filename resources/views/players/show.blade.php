@extends('layouts.app')

@section('title')
    {{$player->name}} Profile | @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <player-edit :id="{{ $player->id }}"></player-edit>
        </div>
    </div>
@endsection

