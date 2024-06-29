@extends('layout')


@section('title')
    {{ __('Проложить путь') }}
@endsection

@section('content')

    @include('inc.breadcrumb', ['name' => __('Проложить путь')])

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">{{ __('Проложить путь') }}</h3>
                    <form>
                        <div class="mb-3">
                            <label for="building_where">{{ __('Вы находитесь в корпусе') }}:</label>
                            <select class="form-control" id="building_where">
                                @foreach($buildings as $building)
                                    <option {{ $loop->first ? 'selected' : '' }} value="{{ $building->id }}">{{ $building->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="auditorium_from">{{ __('Возле аудитории') }}:</label>
                            <select class="form-control" id="auditorium_from"></select>
                        </div>
                        <div class="mb-3">
                            <label for="auditorium_to">{{ __('Вам нужно в аудиторию') }}:</label>
                            <select class="form-control" id="auditorium_to"></select>
                        </div>
                        <button type="button" class="btn btn-success w-100" onclick="drawMap()">{{ __('Проложить') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2" id="floors">
                        <button class="btn btn-warning" onclick="changeFloor(1)">1 этаж</button>
                        <button class="btn btn-outline-warning" onclick="changeFloor(2)">2 этаж</button>
                    </div>
                    <div>
                        <canvas id="mapCanvas" style="max-width: 100%"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>          

@endsection

@pushonce('js')
    @vite('resources/js/path.js')
@endpushonce