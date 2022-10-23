<?php

namespace Atournayre\Helper\Twig\Extension;

use Exception;
use ReflectionClass;
use ReflectionException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EnumExtension extends AbstractExtension
{
    private const METHOD_TO_GET_CSS_FOR_ENUM = 'css';

    public function getFunctions(): array
    {
        return [
            new TwigFunction('enum_value', [$this, 'getEnumValue']),
            new TwigFunction('enum_css', [$this, 'getEnumCss']),
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

        $getterEnum = $getter.'Enum';
        if (!$reflection->hasMethod($getterEnum)) {
            throw new Exception(sprintf('Unable to retrieve enum value, you must implement "%s()" into %s.', $getterEnum, get_class($object)));
        }

        try {
            $reflectionEnum = new ReflectionClass($object->$getterEnum());
            if (!$reflectionEnum->isEnum()) return $object->$getter();

            $enum = constant($reflectionEnum->getName() . '::' . $object->$getter());
            return $enum->value;
        } catch (ReflectionException $reflectionException) {
            throw new Exception(sprintf('Unable to retrieve enum value, you must implement "%s()" into %s.', $getterEnum, get_class($object)), $reflectionException->getCode(), $reflectionException);
        }
    }

    /**
     * @param object $object
     * @param string $property
     *
     * @return string|null
     * @throws Exception
     */
    public function getEnumCss(object $object, string $property): ?string
    {
        $reflection = new ReflectionClass($object);

        $getterEnum = 'get'.ucfirst($property).'Enum';

        if (!$reflection->hasMethod($getterEnum)) return '';

        $enum = $object->$getterEnum();
        $reflectionEnum = new ReflectionClass($enum);

        if (!$reflectionEnum->hasMethod(self::METHOD_TO_GET_CSS_FOR_ENUM)) return '';

        $method = self::METHOD_TO_GET_CSS_FOR_ENUM;
        return $enum->$method();
    }
}
