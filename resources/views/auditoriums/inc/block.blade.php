<div class="mb-3">
    <div class="alert alert-primary m-0">
    <i class="fa-solid fa-building"></i> {{ $building->name }}
    </div>
    <div class="card" style="margin-top: -10px;">
        <div class="card-body">
            @foreach($building->auditoriums as $auditorium)
                @if (!$name || $auditorium->name == $name)
                    <a href="{{ route('auditoriums.show', $auditorium->id) }}" class="btn btn-{{ $auditorium->isOccupiedNow() ? "danger" : "success" }} mb-2 me-2">{{ $auditorium->name }}</a>
                @endif
            @endforeach
        </div>
    </div>
</div>