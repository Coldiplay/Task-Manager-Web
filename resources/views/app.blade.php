<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Управление задачами')</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <style>

        body {
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        main {
            overflow-y: auto;
        }
    </style>
</head>



<body class="bg-light d-flex flex-column">

<!-- Навбар -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="bi bi-check2-square me-2"></i>ТаскМенеджер</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Дашборд</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Задачи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Мой Дашборд</a>
                </li>
                <!-- TODO Показывать ссылку только пользователям с ролью admin -->
                    <li class="nav-item">
                        <a class="nav-link active fw-bold text-warning" href="#"><i class="bi bi-shield-lock me-1"></i>Админка</a>
                    </li>
            </ul>
            <!-- Профиль пользователя -->
            <div class="dropdown text-end">
                <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
{{--                    <img src="https://unsplash.com" alt="mdo" width="32" height="32" class="rounded-circle me-1">--}}
                    {{ Auth::user()->name ?? 'Иван Иванов' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small">
                    <li><a class="dropdown-menu-item" href="#">Профиль</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-menu-item" href="#">Выйти</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>


<!-- Основной контент -->

<main class="flex-grow-1 p-4 bg-light">

    <!-- Алерты (Flash-сообщения) -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') ?? 'Пожалуйста, проверьте форму на ошибки.' }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

</main>

<!-- футер -->
<footer class="bg-dark text-white " >
    <div class="container text-center text-md-start">
                <p>Copyright херачим24/8© 2026 All rights reserved</p>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
@stack('scripts')
</body>
</html>
