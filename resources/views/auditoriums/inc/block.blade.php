<div class="mb-3">
    <div class="alert alert-primary m-0">
        {{ $building->name }}
    </div>
    <div class="card" style="margin-top: -10px;">
        <div class="card-body">
            @foreach($building->auditoriums as $auditorium)
                <a href="{{ route('auditoriums.show', $auditorium->id) }}" class="btn btn-success mb-2 me-2">{{ $auditorium->name }}</a>
            @endforeach
        </div>
    </div>
</div>