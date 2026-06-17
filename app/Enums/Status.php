<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use MoonShine\Support\DTOs\Select\Option;
use MoonShine\Support\DTOs\Select\Options;

/**
 * @method static static NEW()
 * @method static static IN_PROGRESS()
 * @method static static COMPLETED()
 * @method static static CANCELLED()
 */
final class Status extends Enum
{
    const NEW = 'new';
    const IN_PROGRESS = 'in_progress';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';

    public static function getMoonshineOptions(): Options
    {
        return new Options([
            Option::make('Новый', self::NEW),
            Option::make('Выполняется', self::IN_PROGRESS),
            Option::make('Завершено', self::COMPLETED),
            Option::make('Отменено', self::CANCELLED),
        ]);
    }
}
