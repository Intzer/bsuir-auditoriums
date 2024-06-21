@extends('layout')

@section('content')

    @if ($name)
        @include('auditoriums.inc.breadcrumb', ['name' => __('Поиск:').' '.$name])
    @endif


    @php
        $blockCount = 0;
    @endphp

    @foreach($buildings as $building)
        @include('auditoriums.inc.block', compact('building'))
    @endforeach

    @if ($blockCount === 0)
    <div class="alert alert-warning">
        {{ __('Не найдено аудиторий, соответствующим запросу.') }}
    </div>
    @endif
@endsection