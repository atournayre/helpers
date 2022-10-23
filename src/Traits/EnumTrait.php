<?php

namespace Atournayre\Helper\Traits;

use ReflectionClass;

trait EnumTrait
{
    public static function enums(): array
    {
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        $valeurs = array_map(
            function (self $enum) {
                return $enum->value;
            },
            array_values($constants)
        );
        return array_combine(array_keys($constants), $valeurs);
    }

    public static function choicesForForm(): array
    {
        return array_flip(self::enums());
    }

    public static function getValue(?string $enum): ?string
    {
        return self::enums()[$enum] ?? null;
    }

    public static function getByValue(?string $valeur): ?self
    {
        if (!$valeur) return null;

        return self::from(self::getValue($valeur));
    }
}
