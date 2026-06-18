@extends('app')

@section('title', 'Панель администратора')

@section('content')
    <div class="mb-4">
        <h1 class="h2"><i class="bi bi-speedometer2 me-2 text-secondary"></i>Системная панель администратора</h1>
        <p class="text-muted small">Глобальная статистика платформы и управление учетными записями.</p>
    </div>

    <!-- Глобальная статистика (Карточки) -->
    <div class="row g-3 mb-5">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Пользователи</div>
                        <div class="h3 my-1">42</div>
                    </div>
                    <div class="h2 text-primary opacity-50"><i class="bi bi-people"></i></div>
                </div>
                <div class="text-muted small border-top pt-2 mt-2">
                    <span class="text-danger fw-semibold">3</span> заблокировано
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Всего проектов</div>
                        <div class="h3 my-1">12</div>
                    </div>
                    <div class="h2 text-success opacity-50"><i class="bi bi-folder"></i></div>
                </div>
                <div class="text-muted small border-top pt-2 mt-2">
                    <span class="text-success fw-semibold">8</span> активных спринтов
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Всего задач</div>
                        <div class="h3 my-1">156</div>
                    </div>
                    <div class="h2 text-info opacity-50"><i class="bi bi-list-check"></i></div>
                </div>
                <div class="text-muted small border-top pt-2 mt-2">
                    <span class="text-warning fw-semibold">48</span> задач в работе
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Комментарии</div>
                        <div class="h3 my-1">312</div>
                    </div>
                    <div class="h2 text-secondary opacity-50"><i class="bi bi-chat-dots"></i></div>
                </div>
                <div class="text-muted small border-top pt-2 mt-2">
                    За последние 30 дней
                </div>
            </div>
        </div>
    </div>

    <!-- Управление пользователями -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-3 pb-2">
            <h5 class="card-title h6 mb-0"><i class="bi bi-person-gear me-2 text-muted"></i>Управление пользователями и ролями</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th class="ps-3">Пользователь</th>
                    <th>Email</th>
                    <th>Текущая роль</th>
                    <th>Статус</th>
                    <th class="text-end pe-3">Действия</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($users as $user)
                @if( $user->is_blocked === 1)
                <tr class="table-light opacity-75">
                @else
                <tr>
                @endif
                    <td class="ps-3">
                        <div class="d-flex align-items-center gap-2">
                            <!--  <img src="https://unsplash.com" alt="avatar" class="rounded-circle">  -->
                            @if( $user->is_blocked === 0)
                            <div class="fw-bold text-dark">
                            @else
                            <div class="fw-bold text-muted text-decoration-line-through">
                            @endif
                            {{ $user->name }}
                            </div>
                        </div>
                    </td>
                    <td><span class="text-muted small">{{ $user->email }}</span></td>
                    <td>
                        <!-- изменение роли -->
                        <form action="#" method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <select name="role" class="form-select form-select-sm border-warning fw-semibold text-warning" style="width: 140px;" onchange="this.form.submit()">

                                <option value="admin"
                                        @if( $user->role === 'admin')
                                        selected
                                        @endif
                                >admin</option>

                                <option value="manager"
                                        @if( $user->role === 'manager')
                                        selected
                                        @endif
                                >manager</option>
                                <option value="executor"
                                        @if( $user->role === 'executor')
                                        selected
                                        @endif
                                >executor</option>
                            </select>
                        </form>
                    </td>

                    <td><span class="badge bg-success-subtle text-success">Активен</span></td>
                    <td class="text-end pe-3">
                        <button class="btn btn-sm btn-outline-secondary disabled" title="Нельзя заблокировать самого себя"><i class="bi bi-lock"></i></button>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
