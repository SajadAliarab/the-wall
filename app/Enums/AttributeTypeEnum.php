<?php

namespace App\Enums;

enum AttributeTypeEnum: string
{
    case NUMERIC = 'numeric';
    case STRING = 'string';
    case BOOLEAN = 'boolean';
    case LIST = 'list';

    public function validationType(): string
    {
        return match ($this) {
            self::NUMERIC => 'numeric',
            self::STRING => 'string',
            self::BOOLEAN => 'boolean',
            self::LIST => 'array',
        };
    }
}
