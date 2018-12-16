@extends('layouts.app')

@section('title')
    Player #{{$id}} | @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <player-edit :id="{{ $id }}"></player-edit>
        </div>
    </div>
@endsection

