<?php

namespace Atournayre\Helper\Decorator\Form;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Length;

class MaxLengthFormDecorator
{
    private const DATABASE_TEXT_MAXLENGTH = 65535;

    private function __construct()
    {
    }

    public static function decorate(FormInterface $form): void
    {
        $formDataClass = $form->getConfig()->getDataClass();

        foreach ($form->all() as $formElement) {
            $formElementConfig = $formElement->getConfig();
            $options = $formElementConfig->getOptions();

            // Si le champ de formulaire a déjà un maxlength, on ne va pas plus loin
            // On considère que le développeur l'a fait exprès
            if ($options['attr']['maxlength'] ?? null) {
                continue;
            }

            // Si l'élément de formulaire est associé à un data_class
            // Alors il s'agit d'un sous-formulaire
            // On décore donc également ce sous-formulaire
            if (!is_null($formElement->getConfig()->getDataClass())) {
                self::decorate($formElement);
                continue;
            }

            // Si la reflection de propriété échoue, c'est soit que la propriété est non mappée, soit que c'est un bouton
            // On ne va donc pas plus loin
            try {
                $reflectionProperty = new \ReflectionProperty($formDataClass, $formElement->getName());
            } catch (\ReflectionException $e) {
                continue;
            }

            // Si la propriété n'a pas d'attributs
            // On ne va donc pas plus loin
            if ($reflectionProperty->getAttributes() === []) {
                continue;
            }

            // Initialisation d'un tableau pour récupérer les maxlength
            $maxlengths = [];

            // Ajout de la maxlength associée à la contrainte Length si elle existe
            $reflectionAttributesLength = $reflectionProperty->getAttributes(Length::class);
            if ($reflectionAttributesLength !== []) {
                /** @var \ReflectionAttribute $attribute */
                $attribute = current($reflectionAttributesLength);
                $maxlengths[] = $attribute->getArguments()['max'] ?? null;
            }

            // Ajout de la maxlength associée à la colonne Doctrine si elle existe
            $reflectionAttributesColumn = $reflectionProperty->getAttributes(Column::class);
            if ($reflectionAttributesColumn !== []) {
                /** @var \ReflectionAttribute $attribute */
                $attribute = current($reflectionAttributesColumn);
                $arguments = $attribute->getArguments();
                $length = ($arguments['type'] ?? null) === Types::TEXT
                    ? self::DATABASE_TEXT_MAXLENGTH
                    : $arguments['length'] ?? null;
                $maxlengths[] = $length;
            }

            // TODO Ajout de la maxlength associée à EntityValidation

            // Ne conserver que les maxlengths non nulles
            $maxlengths = array_filter($maxlengths);

            // Si aucune maxlength trouvées
            // On ne va donc pas plus loin
            if ($maxlengths === []) {
                continue;
            }

            // On conserve la maxlength la plus petite parmi celles définies ou déterminées
            $maxlength = min($maxlengths);
            $options['attr']['maxlength'] = $maxlength;

            // On override le formulaire
            $form->add($formElement->getName(), get_class($formElementConfig->getType()->getInnerType()), $options);
        }
    }
}
