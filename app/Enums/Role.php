<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use MoonShine\Support\DTOs\Select\Option;
use MoonShine\Support\DTOs\Select\Options;

/**
 * @method static static ADMIN()
 * @method static static MANAGER()
 * @method static static EXECUTOR()
 */
final class Role extends Enum
{
    const ADMIN = 'admin';
    const MANAGER = 'manager';
    const EXECUTOR = 'executor';


    public function toString(): ?string
    {
        return match ($this->key) {
            self::ADMIN => 'Администратор',
            self::MANAGER => 'Менеджер',
            self::EXECUTOR => 'Исполнитель',
        };
    }

    public static function getMoonshineOptions()
    {
        //$test = new Option('Администратор', self::ADMIN);
        //$test->setAttribute('selected', 'true');
//
//        return [
//            self::ADMIN => 'Администратор',
//            self::MANAGER => 'Менеджер',
//            self::EXECUTOR => 'Исполнитель',
//        ];

        return new Options([
            Option::make('Администратор', self::ADMIN,)->disabled(),
             Option::make('Менеджер', self::MANAGER),
            Option::make('Испольнитель', self::EXECUTOR),
        ]);
    }
}
