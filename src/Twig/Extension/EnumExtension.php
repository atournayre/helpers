<?php

namespace Atournayre\Helper\Twig\Extension;

use Exception;
use ReflectionClass;
use ReflectionException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EnumExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('enum_value', [$this, 'getEnumValue']),
        ];
    }

    /**
     * @param object $object
     * @param string $property
     *
     * @return string|null
     * @throws Exception
     */
    public function getEnumValue(object $object, string $property): ?string
    {
        $reflection = new ReflectionClass($object);

        $getter = 'get'.ucfirst($property);
        $getterReadable = $getter.'Readable';
        if ($reflection->hasMethod($getterReadable)) {
            return $object->$getterReadable();
        }

        $getterEnum = $getter.'Enum';
        if ($reflection->hasMethod($getterEnum)) {
            try {
                $reflectionEnum = new ReflectionClass($object->$getterEnum());
                if (!$reflectionEnum->isEnum()) return $object->$getter();

                $enum = constant($reflectionEnum->getName() . '::' . $object->$getter());
                return $enum->value;
            } catch (ReflectionException $reflectionException) {
                throw new Exception(sprintf('Unable to retrieve enum value, you must implement "%s()" into %s.', $getterEnum, get_class($object)), $reflectionException->getCode(), $reflectionException);
            }
        }

        throw new Exception(sprintf('Unable to retrieve enum value, you must implement "%s()" or "%s()" into %s.', $getterReadable, $getterEnum, get_class($object)));
    }
}
