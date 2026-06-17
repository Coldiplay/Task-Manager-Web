<!-- Блок фильтрации и сортировки -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="#applyFilters" class="row g-3">
            <!-- Фильтр по статусу -->
            <div class="col-md-3">
                <label class="form-label small text-muted">Статус</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Все статусы</option>
                    <option value="new">Новая</option>
                    <option value="in_progress">В работе</option>
                    <option value="completed">Завершена</option>
                </select>
            </div>
            <!-- Фильтр по приоритету -->
            <div class="col-md-3">
                <label class="form-label small text-muted">Приоритет</label>
                <select name="priority" class="form-select form-select-sm">
                    <option value="">Все приоритеты</option>
                    <option value="low">Низкий</option>
                    <option value="medium">Средний</option>
                    <option value="high">Высокий</option>
                    <option value="critical">Критический</option>
                </select>
            </div>
            <!-- Фильтр по исполнителю -->
            <!-- Фильтр по исполнителю -->
            <div class="col-md-3">
                <label class="form-label small text-muted">Исполнитель</label>

                <!-- Обычный селект отправляет данные сам по имени 'assignee' -->
                <select name="assignee" class="form-select form-select-sm">
                    <!-- Вариант по умолчанию -->
                    <option value="" {{ !request('assignee') ? 'selected' : '' }}>Все исполнители</option>

                    <!-- Вывод пользователей из базы данных -->
                    @foreach($executors as $executor)
                        <option value="{{ $executor->id }}" {{ request('assignee') == $executor->id ? 'selected' : '' }}>
                            {{ $executor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

    <!-- Сортировка -->
            <div class="col-md-3">
                <label class="form-label small text-muted">Сортировка</label>
                <select name="sort_by" class="form-select form-select-sm">
                    <option value="created_at">Дата создания</option>
                    <option value="priority">Приоритет</option>
                    <option value="deadline">Дедлайн</option>
                </select>
            </div>
            <div class="col-12 text-end">

                <button type="submit" class="btn btn-sm btn-secondary me-2">Применить</button>


                <a href="#clearfilters" class="btn btn-sm btn-link text-decoration-none">Сбросить</a>
            </div>
        </form>
    </div>
</div>
