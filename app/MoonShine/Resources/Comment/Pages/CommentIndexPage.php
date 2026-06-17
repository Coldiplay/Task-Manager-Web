<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Comment\Pages;

use App\Models\Comment;
use App\MoonShine\Resources\Task\TaskResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use App\MoonShine\Resources\Comment\CommentResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends IndexPage<CommentResource>
 */
class CommentIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Содержание', 'body',
                fn(Comment $comment) => strlen($comment->body) > 50
                    ? substr($comment->body, 0, $this->getPosOfCuttedString($comment->body)) . "..."
                    : $comment->body),
            BelongsTo::make('Автор', 'user', fn($user) => $user->name, resource: UserResource::class)
                ->link(fn(string $value, BelongsTo $ctx) => $ctx->getResource()->getDetailPageUrl(
                    Comment::find($ctx->getData()->getKey())->user_id))
            ->sortable(),
            BelongsTo::make('Задача', 'task', fn($task) => $task->title, resource: TaskResource::class)
                    ->link(fn(string $value, BelongsTo $ctx) => $ctx->getResource()->getDetailPageUrl(
                        Comment::find($ctx->getData()->getKey())->task_id))
                ->sortable(),
            Date::make('Создан', 'created_at')->sortable()
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

    private function getPosOfCuttedString(string $string, int $offset = 50): int
    {
        $pos = strpos($string, ' ', $offset);
        if ($pos === false) {
            return strlen($string);
        }
        return $pos;
    }
}
