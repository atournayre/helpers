<?php

namespace Atournayre\Helper;

use Throwable;

class Exception extends \Exception
{
    const ERROR   = 'danger';
    const WARNING = 'warning';
    const INFO    = 'info';

    private $type;

    public static function createAsError(Throwable $throwable): Exception
    {
        return self::createWithType($throwable);
    }

    protected static function createWithType(Throwable $throwable, string $type = self::ERROR): Exception
    {
        $exception = self::createFromThrowable($throwable);
        $exception->type = $type;
        return $exception;
    }

    public static function createFromThrowable(Throwable $throwable): Exception
    {
        return new static($throwable->getMessage(), $throwable->getCode(), $throwable);
    }

    public static function createAsWarning(Throwable $throwable): Exception
    {
        return self::createWithType($throwable, self::WARNING);
    }

    public static function createAsInfo(Throwable $throwable): Exception
    {
        return self::createWithType($throwable, self::INFO);
    }

    public function getType(): string
    {
        return $this->type;
    }
}
