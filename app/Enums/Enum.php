<?php

namespace App\Enums;

use InvalidArgumentException;
use ReflectionClass;

abstract class Enum
{
    public function __construct(private readonly mixed $value)
    {
        if (! in_array($value, static::toArray(), true)) {
            throw new InvalidArgumentException('Invalid value for '.static::class);
        }
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getKey(): string|false
    {
        return static::search($this->value);
    }

    public static function toArray(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    public static function search(mixed $value): string|false
    {
        return array_search($value, static::toArray(), true);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
