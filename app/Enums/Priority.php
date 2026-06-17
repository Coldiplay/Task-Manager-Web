<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static LOW()
 * @method static static MEDIUM()
 * @method static static HIGH()
 * @method static static CRITICAL()
 */
final class Priority extends Enum
{
    const LOW = 'low';
    const MEDIUM = 'medium';
    const HIGH = 'high';
    const CRITICAL = 'critical';


    public static function getMoonshineOptions(): array
    {
        return [
            self::LOW => 'Низкий',
            self::MEDIUM => 'Средний',
            self::HIGH => 'Высокий',
            self::CRITICAL => 'Чрезвычайный',
        ];
    }
}
