<header class="my-2">
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <form action="{{ route('auditoriums.index') }}" method="get" class="d-flex m-auto">
                <input class="form-control me-2" type="text" name="name" placeholder="{{ __('Номер аудитории') }}">
                <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </nav>
</header>