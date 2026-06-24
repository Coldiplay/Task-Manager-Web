<!DOCTYPE html>

@extends('app')

@section('title', 'Список задач')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Управление задачами</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            <i class="bi bi-plus-lg me-2"></i>Новая задача
        </button>
    </div>
    <!-- Дашборд (Статистика) -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="text-muted small text-uppercase fw-bold">Всего задач</div>
                <div class="h3 my-2">{{ $tasks->total() }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3 border-start border-primary border-4">
                <div class="text-muted small text-uppercase fw-bold">Новые</div>
                <div class="h3 my-2 text-primary">{{ $all_tasks->where('status', 'new')->count() }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3 border-start border-warning border-4">
                <div class="text-muted small text-uppercase fw-bold">В работе</div>
                <div class="h3 my-2 text-warning">{{ $all_tasks->where('status', 'in_progress')->count() }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3 border-start border-success border-4">
                <div class="text-muted small text-uppercase fw-bold">Завершены</div>
                <div class="h3 my-2 text-success">{{ $all_tasks->where('status', 'completed')->count() }}</div>
            </div>
        </div>
    </div>

    @php($executors = $users->where('role', 'executor'))
    <!-- фильты>-->
    @include('filters')

      <!-- Таблица задач -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>Название</th>
                    <th>Статус</th>
                    <th>Приоритет</th>
                    <th>Исполнитель</th>
                    <th>Дедлайн</th>
                    <th class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($tasks as $task)
                <!-- строка задачи -->
                <tr>
                    <td>
                        <div class="fw-bold text-dark">{{ $task->title }}</div>
                        <small class="text-muted">Автор: {{ $task->author->name }}</small>
                    </td>
                    <td><span class="badge bg-info text-dark">{{ $task->status }}</span></td>
                    <td><span class="badge" style="color: hsl({{120 - (120/(count($priorities)-1)) * array_search($task->priority, $priorities)}}, 80%, 50%)">{{ $task->priority }}</span></td>
                    <td> {{ $task->assignee->name }}</td>
                    <td><span class="text-danger fw-semibold">{{ $task->due_date }}</span></td>
                    <td class="text-end">
                        <div class="btn-group" role="group" aria-label="Действия над задачей">
                            <!-- Просмотр -->
                            <a href="{{ route('task.show', [$task->project, $task]) }}" class="btn btn-outline-secondary d-inline-flex align-items-center" title="Просмотр и комментарии">
                                <i class="bi bi-eye"></i>
                            </a>

                            <!-- Редактировать -->
                            <button type="button" class="btn btn-outline-secondary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#editTaskModal" title="Редактировать">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <!-- Удалить -->
                            <form action="#delete" method="POST" class="d-inline" onsubmit="return confirm('Удалить задачу?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger d-inline-flex align-items-center h-100" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" title="Удалить">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <!-- Пагинация  -->

        <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3">
            <small class="text-muted">
                Показано {{ $tasks->firstItem() }}-{{ $tasks->lastItem() }} из {{ $tasks->total() }} задач
            </small>
            {{ $tasks->links('vendor.pagination.bootstrap-5') }}
        </div>






    <!-- Модальное окно создания задачи -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-hidden="true">
        <!-- Выбор проекта (Группировка задач) -->
        <div class="col-12">
            <label class="form-label">Проект</label>
            <select name="project_id" class="form-select">
                <option value="">Без проекта (Одиночная задача)</option>
                <!-- Вывод списка всех проектов из базы -->
                <option value="1">Не спать</option>
                <option value="2">тоже не спать</option>
            </select>
        </div>

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Создание новой задачи</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="#" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body row g-3">
                        <!-- Название -->
                        <div class="col-12">
                            <label class="form-label">Название задачи <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <!-- Описание -->
                        <div class="col-12">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <!-- Статус -->
                        <div class="col-md-6">
                            <label class="form-label">Статус</label>
                            <select name="status" class="form-select">
                                <option value="new">Новая</option>
                                <option value="in_progress">В работе</option>
                                <option value="completed">Завершена</option>
                            </select>
                        </div>
                        <!-- Приоритет -->
                        <div class="col-md-6">
                            <label class="form-label">Приоритет</label>
                            <select name="priority" class="form-select">
                                <option value="low">Низкий</option>
                                <option value="medium" selected>Средний</option>
                                <option value="high">Высокий</option>
                                <option value="critical">Критический</option>
                            </select>
                        </div>
                        <!-- Исполнитель -->
                        <div class="col-md-6">
                            <label class="form-label">Исполнитель</label>
                            <select name="assigned_to" class="form-select">
                                <option value="">Выберите пользователя...</option>
                                <option value="1">Алексей Петров</option>
                                <option value="2">Ольга Сидорова</option>
                            </select>
                        </div>
                        <!-- Дедлайн -->
                        <div class="col-md-6">
                            <label class="form-label">Дедлайн</label>
                            <input type="date"
                                   name="deadline"
                                   value="{{ old('deadline') }}"
                                   class="form-control @error('deadline') is-invalid @enderror">
                            @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div> <!-- / .modal-body (конец строки row g-3) -->

                    <!-- футер модального окна с кнопками действий -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Создать задачу</button>
                    </div>

                </form> <!-- / Конец формы создания -->
            </div>
        </div>
    </div> <!-- / Конец модального окна #createTaskModal -->



    @push('scripts')
        @if($errors->any())
            <script>
                // ждать полной загрузки всех стилей, картинок и скриптов window
                window.addEventListener("load", function() {
                    // Проверяем, доступен ли Bootstrap в глобальной видимости
                    if (typeof bootstrap !== 'undefined') {
                        var modalElement = document.getElementById('createTaskModal');
                        if (modalElement) {
                            var myModal = new bootstrap.Modal(modalElement);
                            myModal.show();
                        }
                    }
                });
            </script>
        @endif
    @endpush


@endsection

