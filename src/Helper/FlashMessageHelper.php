<?php

namespace Atournayre\Helper\Helper;

class FlashMessageHelper
{
    const TYPE_WARNING = 'warning';
    const TYPE_SUCCESS = 'success';
    const TYPE_DANGER = 'danger';
    const TYPE_INFO = 'info';

    const MESSAGE_ERREUR = 'Une erreur est survenue.';
    const MESSAGE_ERREUR_FORMULAIRE = 'Une erreur est survenue lors de l\'enregistrement du formulaire.';

    public static function aEteCree(string $element): string
    {
        return sprintf('%s a été créé.', $element);
    }

    public static function aEteCreee(string $element): string
    {
        return sprintf('%s a été créée.', $element);
    }

    public static function aEteModifie(string $element): string
    {
        return sprintf('%s a été modifié.', $element);
    }

    public static function aEteModifiee(string $element): string
    {
        return sprintf('%s a été modifiée.', $element);
    }

    public static function ontEteCrees(string $element): string
    {
        return sprintf('%s ont été créés.', $element);
    }

    public static function ontEteCreees(string $element): string
    {
        return sprintf('%s ont été créées.', $element);
    }

    public static function ontEteModifies(string $element): string
    {
        return sprintf('%s ont été modifiés.', $element);
    }

    public static function ontEteModifiees(string $element): string
    {
        return sprintf('%s ont été modifiées.', $element);
    }

    public static function ontEteSupprimes(string $element): string
    {
        return sprintf('%s ont été supprimés.', $element);
    }

    public static function ontEteSupprimees(string $element): string
    {
        return sprintf('%s ont été supprimées.', $element);
    }
}
