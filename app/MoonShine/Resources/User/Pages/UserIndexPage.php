<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User\Pages;

use App\Enums\Role;
use App\Models\Task;
use App\Models\User;
use App\MoonShine\Resources\Comment\CommentResource;
use App\MoonShine\Resources\Task\TaskResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use MoonShine\Contracts\Core\DependencyInjection\CrudRequestContract;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\MoonShineRequest;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Boolean;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\ID;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends IndexPage<UserResource>
 */
class UserIndexPage extends IndexPage
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
            Text::make("E-mail", 'email')
                ->sortable(),
            Text::make("ФИО", 'name')
                ->sortable(),
            Select::make("Роль", 'role')
                ->options(Role::getMoonshineOptions())
                ->sortable()
                ->updateOnPreview(fn($item) => route('admin.users.role', $item->getKey())),
            HasMany::make('Назначенные задачи', 'assignedTasks', resource: TaskResource::class)
                ->relatedLink('assignee', function (int $count, Field $field)
                {
                    return $count > 0;
                }),
            HasMany::make('Созданные задачи', 'authoredTasks', resource: TaskResource::class)
                ->relatedLink('author', function (int $count, Field $field)
                {
                    return $count > 0;
                }),

            HasMany::make('Комментарии', 'comments', resource: CommentResource::class)
            ->relatedLink('user', function (int $count, Field $field)
            {
               return $count > 0;
            }),
            Checkbox::make('Забанен', 'is_blocked')->sortable(),
        ];
    }

    /**
     * @return ListOf<ActionButtonContract>
     */
    protected function buttons(): ListOf
    {
//        (ActionButton::make('Бан/разбан',)->method('banUser'))->canSee(fn(User $user) => $user->is_blocked);
//        dd(parent::buttons()
//            ->add(ActionButton::make('Бан/разбан',)->method('banUser')->canSee(fn(User $user) => $user->is_blocked)));
        $buttons = parent::buttons();
        $buttons->add((ActionButton::make('Бан/разбан',)->method('banUser')));

//        foreach ($buttons as $button) {
//            if ($button->getName() == 'resource-detail-button')
//            {
//                $button->canSee(fn() => true);
//            }
//        }
        //dd($buttons);
        return $buttons;
    }


    #[AsyncMethod]
    public function banUser()
    {
        $user = $this->resource->getItem();

        $user->update(['is_blocked' => !$user->is_blocked]);

        return back();
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
