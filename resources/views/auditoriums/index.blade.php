@extends('layout')

@section('content')
    @foreach($buildings as $building)
        @include('auditoriums.inc.block', compact('building'))
    @endforeach
@endsection