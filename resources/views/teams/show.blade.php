@extends('layouts.app')

@section('title')
    Team #{{$id}} | @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <team-edit :id="{{ $id }}"></team-edit>
        </div>
    </div>
@endsection

