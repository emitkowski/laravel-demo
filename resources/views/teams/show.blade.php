@extends('layouts.app')

@section('title')
    {{$team->name}} | @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <team-edit :id="{{ $team->id }}"></team-edit>
        </div>
    </div>
@endsection

