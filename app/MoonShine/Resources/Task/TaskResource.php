<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Task;

use Closure;
use App\Models\Task;
use App\MoonShine\Resources\Task\Pages\TaskIndexPage;
use App\MoonShine\Resources\Task\Pages\TaskFormPage;
use App\MoonShine\Resources\Task\Pages\TaskDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Task, TaskIndexPage, TaskFormPage, TaskDetailPage>
 */
class TaskResource extends ModelResource
{
    protected string $model = Task::class;

    protected string $title = 'Задачи';

    protected bool $withPolicy = true;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            TaskIndexPage::class,
            TaskFormPage::class,
            TaskDetailPage::class,
        ];
    }


    protected function resolveOrder(string $column, string $direction, ?Closure $callback): static
    {
        if ($callback instanceof Closure) {

            $callback($this->newQuery(), $column, $direction);

        } elseif ($column === 'priority') {

            if ('asc' === $direction) {
                $this->newQuery()->orderByRaw('CASE priority WHEN \'low\' THEN 1 WHEN \'medium\' THEN 2 WHEN \'high\' THEN 3 WHEN \'critical\' THEN 4 ELSE 5 END;');
            } elseif ('desc' === $direction) {
                $this->newQuery()->orderByRaw('CASE priority WHEN \'low\' THEN 4 WHEN \'medium\' THEN 3 WHEN \'high\' THEN 2 WHEN \'critical\' THEN 1 ELSE 5 END;');
            } else{
                $this->newQuery()->orderBy($column, $direction);
            }

        } else {

            $this->newQuery()->orderBy($column, $direction);

        }

        return $this;
    }
}
