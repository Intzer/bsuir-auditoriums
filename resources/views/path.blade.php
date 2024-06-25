@extends('layout')


@section('title')
    {{ __('Проложить путь') }}
@endsection

@section('content')

    @include('inc.breadcrumb', ['name' => __('Проложить путь')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">{{ __('Проложить путь') }}</h3>
                    <form>
                        <div class="mb-3">
                            <label for="building_from">{{ __('Вы находитесь в корпусе') }}:</label>
                            <select class="form-control" id="building_from">
                                @foreach($buildings as $building)
                                    <option {{ $loop->first ? 'selected' : '' }} value="{{ $building->id }}">{{ $building->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="auditorium_from">{{ __('Возле вас кабинет') }}:</label>
                            <select class="form-control" id="auditorium_from"></select>
                        </div>
                        <div class="mb-3">
                            <label for="building_to">{{ __('Вам нужно в корпус') }}:</label>
                            <select class="form-control" id="building_to">
                                @foreach($buildings as $building)
                                    <option {{ $loop->first ? 'selected' : '' }} value="{{ $building->id }}">{{ $building->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="auditorium_to">{{ __('В аудиторию') }}:</label>
                            <select class="form-control" id="auditorium_to"></select>
                        </div>
                        <button type="button" class="btn btn-success w-100">{{ __('Проложить') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@pushonce('js')
    <script src="/assets/js/path.js"></script>
@endpushonce