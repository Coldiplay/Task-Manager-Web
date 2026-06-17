<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Task\Pages;

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\Project;
use App\Models\Task;
use App\MoonShine\Resources\Project\ProjectResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\Contracts\UI\FieldContract;
use App\MoonShine\Resources\Task\TaskResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends DetailPage<TaskResource>
 */
class TaskDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'title'),
            Select::make('Статус', 'status')
                ->options(Status::getMoonshineOptions()),
            Select::make('Приоритет', 'priority')
                ->options(Priority::getMoonshineOptions()),

            BelongsTo::make('Проект','project', fn($user) => $user->name, ProjectResource::class)
                ->link(fn(string $value, BelongsTo $ctx) => $ctx->getResource()
                    ->getDetailPageUrl(Task::find($ctx->getData()->getKey())->project_id))
                ->sortable(),

            BelongsTo::make('Автор','author', fn($user) => $user->name, UserResource::class)
                ->link(fn(string $value, BelongsTo $ctx) => $ctx->getResource()
                    ->getDetailPageUrl(Task::find($ctx->getData()->getKey())->author_id))
                ->sortable(),

            BelongsTo::make('Исполнитель','assignee', fn($user) => $user->name, UserResource::class)
                ->link(fn(string $value, BelongsTo $ctx) => $ctx->getResource()
                    ->getDetailPageUrl(Task::find($ctx->getData()->getKey())->assignee_id))
                ->sortable(),

            Date::make('Срок', 'due_date'),
            Date::make('Создано', 'created_at'),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    /**
     * @param  TableBuilder  $component
     *
     * @return TableBuilder
     */
    protected function modifyDetailComponent(ComponentContract $component): ComponentContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}
