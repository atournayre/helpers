<?php

namespace Atournayre\Helper\Helper;

class JsonResponseHelper
{
    public static function jsonErreur(string $messageErreur): array
    {
        return [
            'type' => 'error',
            'message' => $messageErreur,
        ];
    }

    public static function jsonSuccess(string $messageSucces, array $data): array
    {
        return [
            'type' => 'success',
            'message' => $messageSucces,
            'data' => $data,
        ];
    }
}
