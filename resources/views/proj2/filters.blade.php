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
    <div class="col-md-3">
        <label class="form-label small text-muted">Исполнитель</label>
        <div class="dropdown">
            <!-- Кнопка,  select -->
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle w-100 text-start" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Все исполнители
            </button>
            <!-- Выпадающее меню -->
            <div class="dropdown-menu p-2 w-100" aria-labelledby="userDropdown">
                <!-- Инпут для быстрого поиска -->
                <input type="text" class="form-control form-control-sm mb-2" id="userSearch" placeholder="Поиск...">
                <!-- Скроллируемый контейнер для списка -->
                <div id="userList" style="max-height: 200px; overflow-y: auto;">
                    <button class="dropdown-item small active" type="button" data-value="">Все исполнители</button>
                    <!-- Вывод из БД -->
                    <button class="dropdown-item small" type="button" data-value="1">Алексей Петров</button>
                    <button class="dropdown-item small" type="button" data-value="2">Ольга Сидорова</button>
                </div>
            </div>
        </div>
        <!-- Скрытое поле для отправки формы -->
        <input type="hidden" name="assignee" id="assignee-hidden-input" value="">
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
