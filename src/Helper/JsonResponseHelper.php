<?php

namespace Atournayre\Helper\Helper;

class JsonResponseHelper
{
    public static function erreur(string $messageErreur): array
    {
        return [
            'type' => 'error',
            'message' => $messageErreur,
        ];
    }

    public static function succes(string $messageSucces, array $data): array
    {
        return [
            'type' => 'success',
            'message' => $messageSucces,
            'data' => $data,
        ];
    }
}
