<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Task\Pages;

use App\Enums\Priority;
use App\Models\Task;
use App\MoonShine\Resources\Comment\CommentResource;
use App\MoonShine\Resources\Project\ProjectResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Fields\Relationships\HasOne;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\ID;
use App\MoonShine\Resources\Task\TaskResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends IndexPage<TaskResource>
 */
class TaskIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()
                ->sortable(),
            Text::make('Название', 'title')
                ->sortable(),
            Select::make('Статус', 'priority')
                ->options(Priority::getMoonshineOptions())
                ->sortable(),

            BelongsTo::make('Проект','project', fn($user) => $user->name, ProjectResource::class)
                ->link(fn(string $value, BelongsTo $ctx) => $ctx->getResource()
                    ->getDetailPageUrl(Task::find($ctx->getData()->getKey())->project_id))
                ->sortable(),

            BelongsTo::make('Исполнитель', 'assignee',
                fn($user) => $user->name, UserResource::class)
                ->link(fn(string $value, BelongsTo $ctx) => $ctx->getResource()
                    ->getDetailPageUrl(Task::find($ctx->getData()->getKey())->assignee_id))
            ->sortable(),
            BelongsTo::make('Автор', 'author',
                fn($user) => $user->name, UserResource::class)
                ->link(fn(string $value, BelongsTo $ctx) => $ctx->getResource()
                    ->getDetailPageUrl(Task::find($ctx->getData()->getKey())->author_id))
            ->sortable(),

            HasMany::make('Комментарии', 'comments', fn($comment) => $comment->name, CommentResource::class)
            ->relatedLink('task', function (int $count, Field $field)
            {
                return $count > 0;
            }),

            Date::make('Срок', 'due_date')
                ->sortable(),
            Date::make('Создан', 'created_at')
                ->sortable(),
        ];
    }

    /**
     * @return ListOf<ActionButtonContract>
     */
    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [];
    }

    /**
     * @return list<QueryTag>
     */
    protected function queryTags(): array
    {
        return [];
    }

    /**
     * @return list<Metric>
     */
    protected function metrics(): array
    {
        return [];
    }

    /**
     * @param  TableBuilder  $component
     *
     * @return TableBuilder
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
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
