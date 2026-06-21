```html
@extends('app')

@section('title', 'Просмотр задачи')

@section('content')
    <div class="mb-3">
        <a href="#" class="btn btn-sm btn-link text-decoration-none ps-0"><i class="bi bi-arrow-left me-1"></i> Назад к списку</a>
    </div>

    <div class="row g-4">
        <!-- Левая колонка: Основная инфо задачи -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-info text-dark">{{$task->status}}</span>
                        <span class="badge bg-danger">{{$task->priority}}</span>
                    </div>
                    <h2 class="card-title h3 mb-3">{{$task->title}}</h2>
                    <p class="text-secondary">{{$task->description}}</p>
                </div>
            </div>

            <!-- Секция комментариев -->
            <h4 class="h5 mb-3"><i class="bi bi-chat-text me-2"></i>Комментарии (1)</h4>

            <!-- Форма добавления -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="comment" class="form-control" rows="2" placeholder="Напишите комментарий..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Отправить</button>
                    </form>
                </div>
            </div>

            <!-- Лента комментариев -->
            <div class="d-flex flex-column gap-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold small">Ольга Сидорова</span>
                            <span class="text-muted small">17.06.2026 10:15</span>
                        </div>
                        <p class="card-text small mb-0">Спецификацию по JWT прикрепила в техническое задание. Проверьте, пожалуйста.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Правая колонка: Метаданные -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm text-dark">
                <div class="card-body">
                    <h5 class="card-title h6 border-bottom pb-2 mb-3">Детали задачи</h5>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Исполнитель</label>
                        <span class="fw-semibold">Алексей Петров</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Автор</label>
                        <span class="fw-semibold">Администратор</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Дедлайн</label>
                        <span class="text-danger fw-semibold">18.06.2026</span>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small d-block">Создана</label>
                        <span class="text-muted">15.06.2026 14:00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
