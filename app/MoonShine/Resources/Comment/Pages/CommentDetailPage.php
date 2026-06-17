<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Comment\Pages;

use App\Models\Comment;
use App\MoonShine\Resources\Task\TaskResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\Contracts\UI\FieldContract;
use App\MoonShine\Resources\Comment\CommentResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Throwable;


/**
 * @extends DetailPage<CommentResource>
 */
class CommentDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Textarea::make('Содержание', 'body'),
            BelongsTo::make('Автор', 'user', fn($user) => $user->name, UserResource::class)
                ->link(fn(string $value, BelongsTo $ctx) => $ctx->getResource()->getDetailPageUrl(
                    Comment::find($ctx->getData()->getKey())->user_id)),
            BelongsTo::make('Задача', 'task', fn($task) => $task->title, TaskResource::class)
                ->link(fn(string $value, BelongsTo $ctx) => $ctx->getResource()->getDetailPageUrl(
                    Comment::find($ctx->getData()->getKey())->task_id))
                ->sortable(),
        ];
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
