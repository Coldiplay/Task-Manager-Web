@extends('app')

@section('title', 'Личный дашборд')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-auto text-center text-md-start mb-3 mb-md-0">
            <!--<img src="https://unsplash.com" alt="avatar" class="rounded-circle shadow-sm border border-2 border-white">-->
        </div>
        <div class="col-12 col-md">
            <h1 class="h3 mb-1">Привет, {{ Auth::user()->name ?? 'Иван Иванов' }}!</h1>
            <p class="text-muted small mb-0">Сводка по вашим персональным задачам на сегодня.</p>
        </div>
    </div>

    <!-- Блоки статистики пользователя -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm p-3 border-start border-primary border-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Назначены мне</div>
                        <div class="h3 my-1 text-primary">{{Auth::user()->assignedTasks()->count()}}</div>
                    </div>
                    <div class="h2 text-muted opacity-50"><i class="bi bi-person-check"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm p-3 border-start border-info border-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Созданы мной</div>
                        <div class="h3 my-1 text-info">{{Auth::user()->authoredTasks()->count()}}</div>
                    </div>
                    <div class="h2 text-muted opacity-50"><i class="bi bi-person-plus"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm p-3 border-start border-danger border-4 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-danger small text-uppercase fw-bold">Просроченные задачи</div>
                        <div class="h3 my-1 text-danger fw-bold">2 {{--хз--}}</div>
                    </div>
                    <div class="h2 text-danger opacity-50"><i class="bi bi-exclamation-octagon"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Вкладки (Назначенные / Созданные) -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-3">
            <ul class="nav nav-tabs card-header-tabs" id="dashboardTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-semibold" id="assigned-tab" data-bs-toggle="tab" data-bs-target="#assigned" type="button" role="tab"><i class="bi bi-briefcase me-2"></i>Поручено мне</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-semibold" id="created-tab" data-bs-toggle="tab" data-bs-target="#created" type="button" role="tab"><i class="bi bi-pencil-square me-2"></i>Создано мной</button>
                </li>
            </ul>
        </div>
        <div class="card-body px-0 pb-0">
            <div class="tab-content" id="dashboardTabsContent">

                <!-- ВКЛАДКА 1: НАЗНАЧЕННЫЕ МНЕ ЗАДАЧИ -->
                <div class="tab-pane fade show active" id="assigned" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="ps-3">Задача</th>
                                <th>Приоритет</th>
                                <th>Дедлайн</th>
                                <th>Проект</th>
                                <th style="width: 200px;">Быстрая смена статуса</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(Auth::user()->assignedTasks as $myTask)
                                <tr @if($myTask->status) @endif></tr>
                            @endforeach
                            <!-- Пример критической просроченной задачи -->
                            <tr class="table-danger-subtle">
                                <td class="ps-3">
                                    <div class="fw-bold text-dark">Исправить баг сессии на фронтенде</div>
                                    <small class="text-muted">Автор: Ольга Сидорова</small>
                                </td>
                                <td><span class="badge bg-danger">Критический</span></td>
                                <td><span class="text-danger fw-bold"><i class="bi bi-calendar-x me-1"></i>16.06.2026</span></td>
                                <td><span class="text-muted">Ребрендинг сайта</span></td>
                                <td>
                                    <!-- Форма быстрой смены статуса -->
                                    <form action="#" method="POST" class="quick-status-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm border-danger text-danger bg-transparent" onchange="this.form.submit()">
                                            <option value="new">Новая</option>
                                            <option value="in_progress" selected>В работе</option>
                                            <option value="completed">Завершена</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>

                            <!-- Обычная задача -->
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold text-dark">Написать юнит-тесты контроллеров</div>
                                    <small class="text-muted">Автор: Администратор</small>
                                </td>
                                <td><span class="badge bg-warning text-dark">Средний</span></td>
                                <td><span class="text-muted">25.06.2026</span></td>
                                <td><span class="text-muted">—</span></td>
                                <td>
                                    <form action="#" method="POST" class="quick-status-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm border-secondary-subtle" onchange="this.form.submit()">
                                            <option value="new" selected>Новая</option>
                                            <option value="in_progress">В работе</option>
                                            <option value="completed">Завершена</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ВКЛАДКА 2: СОЗДАННЫЕ МНОЙ ЗАДАЧИ -->
                <div class="tab-pane fade" id="created" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="ps-3">Задача</th>
                                <th>Статус</th>
                                <th>Приоритет</th>
                                <th>Исполнитель</th>
                                <th>Дедлайн</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold text-dark">Подготовить отчет по спринту №4</div>
                                    <small class="text-muted">Создано: 15.06.2026</small>
                                </td>
                                <td><span class="badge bg-success">Завершена</span></td>
                                <td><span class="badge bg-secondary">Низкий</span></td>
                                <td>Алексей Петров</td>
                                <td><span class="text-muted">20.06.2026</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
