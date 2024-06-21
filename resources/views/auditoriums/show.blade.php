@extends('layout')

@section('content')
    @include('auditoriums.inc.breadcrumb', ['name' => $auditorium->name.'-'.$auditorium->building->name])

    <div class="row mb-2">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">{{ __('Аудитория').' '.$auditorium->name.'-'.$auditorium->building->name }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-md-6 order-1 order-md-0">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">{{ __('Занятия') }}</h3>
                    <div>
                        @if ($auditorium->lessons->isNotEmpty())
                            @foreach($weekDays as $weekDay)
                                @if ($auditorium->lessons()->where('week_day_id', $weekDay->id)->get()->isNotEmpty())
                                    <div class="mb-2">
                                        <h5 class="text-center">{{ $weekDay->name }}</h5>
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Название') }}</th>
                                                        <th>{{ __('Группа') }}</th>
                                                        <th>{{ __('Время') }}</th>
                                                        <th>{{ __('Недели') }}</th>
                                                        <th>{{ __('Пометка') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($auditorium->lessons()->where('week_day_id', $weekDay->id)->get() as $lesson)
                                                        <tr class="{{ $lesson->isPassingNow() ? 'table-success' : "" }}">
                                                            <td>{{ $lesson->name }}</td>
                                                            <td>
                                                                {{ $lesson->group->name }}
                                                                @if($lesson->num_subgroup != 0)
                                                                    {{ $lesson->num_subgroup.'-'.__('подгруппа') }}
                                                                    <i class="fa-solid fa-user-group"></i>
                                                                @endif
                                                            </td>
                                                            <td>{{ $lesson->start_time.'-'.$lesson->end_time }}</td>
                                                            <td>
                                                                @foreach($lesson->weeksNumbers as $weekNumber)
                                                                    @if($loop->first)
                                                                        {{ $weekNumber->id }}
                                                                    @else
                                                                        {{ ', '.$weekNumber->id }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $lesson->note ?? "-" }}</td>
                                                        </tr>
                                                    @endforeach      
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            {{ __('Занятий в данной аудитории нет.') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 order-0 oreder-md-1 mb-2 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">{{ __('Сейчас') }}</h3>
                    <div>
                        Время: <span class="fw-bolder">{{ $nowTimeText }}</span>
                    </div>
                    <div>
                        День недели: <span class="fw-bolder">{{ $weekDayText }}</span>
                    </div>
                    <div>
                        Номер недели: <span class="fw-bolder">{{ $weekMonthText }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection