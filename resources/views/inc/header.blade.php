<header>
    <nav class="navbar bg-body-tertiary py-3">
        <div class="container">
            <form action="{{ route('auditoriums.index') }}" method="get" class="d-flex mx-auto">
                <input class="form-control me-2" type="text" name="name" placeholder="{{ __('Номер аудитории') }}">
                <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <a class="btn btn-outline-secondary" href="{{ route('path.index') }}">{{ __('Проложить путь') }}</a>
        </div>
    </nav>
</header>