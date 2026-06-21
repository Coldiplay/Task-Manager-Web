@php use App\Models\Task; @endphp
@extends('app')

@section('title', 'Управление проектами')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Управление проектами</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProjectModal">
            <i class="bi bi-folder-plus me-2"></i>Новый проект
        </button>
    </div>

    <!-- Сетка проектов -->
    <div class="row g-4">
        <!-- Пример карточки одного проекта (Повторяется в цикле foreach) -->
        @foreach($projects as $project)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title text-dark mb-0">{{$project->name}}</h5>
                            <!-- Действия CRUD -->
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button class="dropdown-item small" data-bs-toggle="modal"
                                                data-bs-target="#editProjectModal" data-id="1"
                                                data-name="Ребрендинг сайта" data-desc="Обновление дизайна и фронтенда">
                                            <i class="bi bi-pencil me-2 text-muted"></i>Редактировать
                                        </button>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="#" method="POST"
                                              onsubmit="return confirm('Удалить проект? Все задачи останутся без проекта.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item small text-danger">
                                                <i class="bi bi-trash me-2"></i>Удалить
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <p class="text-secondary small text-truncate-2 mb-3" style="height: 42px;">
                            {{$project->description}}
                        </p>

                        <!-- Прогресс задач в проекте -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1 small text-muted">
                                <span>Прогресс задач</span>
                                @php
                                    $tasks = $project->tasks();
                                    $progress = round(($tasks->where(['status' => 'completed'])->orWhere(['status' => 'cancelled']))->count()/$tasks->count(), 2);
                                @endphp
                                <span class="fw-bold"> {{$progress}}%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{$progress}}%"></div>
                            </div>
                        </div>

                        <!-- Краткая статистика -->
                        <div class="d-flex justify-content-between align-items-center text-muted small border-top pt-2">
                            <span><i class="bi bi-list-task me-1"></i> {{$tasks->count()}} задач</span>
                            <span
                                class="badge bg-light text-dark border">В работе: {{$tasks->where(['status' => 'in_progress'])->count()}}</span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                        <a href="{{route('task.index', $project)}}" class="btn btn-sm btn-outline-primary w-100">Открыть
                            задачи проекта</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Модальное окно: Создание проекта -->
    <div class="modal fade" id="createProjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Создание проекта</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/projects/store" method="POST">
                    @csrf
                    <div class="modal-body row g-3">
                        <div class="col-12">
                            <label class="form-label">Название проекта <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>

                <!-- Фильтр по исполнителю -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Исполнитель</label>
                    <div class="dropdown">
                        <!-- Кнопка,  select -->
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle w-100 text-start" type="button"
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Все исполнители
                        </button>
                        <!-- Выпадающее меню -->
                        <div class="dropdown-menu p-2 w-100" aria-labelledby="userDropdown">
                            <!-- Инпут для быстрого поиска -->
                            <input type="text" class="form-control form-control-sm mb-2" id="userSearch"
                                   placeholder="Поиск...">
                            <!-- Скроллируемый контейнер для списка -->
                            <div id="manager_id" style="max-height: 200px; overflow-y: auto;">
                                <button class="dropdown-item small active" type="button" data-value="">Все исполнители
                                </button>
                                <!-- Вывод из БД -->
                                @foreach ($users as $user)
                                    <button class="dropdown-item small" type="button"
                                            data-value="{{$user->id}}">{{$user->name}}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Модальное окно: Редактирование проекта -->
        <div class="modal fade" id="editProjectModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактировать проект</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="#" method="POST" id="editProjectForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body row g-3">
                            <div class="col-12">
                                <label class="form-label">Название проекта <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit_project_name" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Описание</label>
                                <textarea name="description" id="edit_project_description" class="form-control"
                                          rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                // Скрипт автозаполнения формы редактирования данными из data-атрибутов кнопки
                window.addEventListener("load", function () {
                    var editModal = document.getElementById('editProjectModal');
                    if (editModal) {
                        editModal.addEventListener('show.bs.modal', function (event) {
                            var button = event.relatedTarget;

                            // Извлекаем данные
                            var id = button.getAttribute('data-id');
                            var name = button.getAttribute('data-name');
                            var description = button.getAttribute('data-desc');

                            // Заполняем поля
                            document.getElementById('edit_project_name').value = name;
                            document.getElementById('edit_project_description').value = description;

                            // Динамически меняем action формы под нужный ID (например: /projects/1)
                            document.getElementById('editProjectForm').action = '/projects/' + id;
                        });
                    }
                });
            </script>
    @endpush
@endsection
