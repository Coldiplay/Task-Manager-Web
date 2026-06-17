<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\User\UserResource;
use App\MoonShine\Resources\Comment\CommentResource;
use App\MoonShine\Resources\Task\TaskResource;
use App\MoonShine\Resources\Project\ProjectResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                UserResource::class,
                CommentResource::class,
                TaskResource::class,
                ProjectResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ]);
    }
}
