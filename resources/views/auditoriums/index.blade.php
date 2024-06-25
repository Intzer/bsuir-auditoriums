@extends('layout')

@section('content')

    @if ($name)
        @include('inc.breadcrumb', ['name' => __('Поиск:').' '.$name])
    @endif


    @php
        $blockCount = 0;
    @endphp

    @foreach($buildings as $building)
        @if(!$name || $building->auditoriums->contains('name', $name))
            @include('auditoriums.inc.block', compact('building'))

            @php
                $blockCount += 1;
            @endphp
        @endif
    @endforeach

    @if ($blockCount == 0)
    <div class="alert alert-warning">
        {{ __('Не найдено аудиторий, соответствующим запросу.') }}
    </div>
    @endif
@endsection