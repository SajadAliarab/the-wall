<?php

namespace App\Enums;

enum AttributeTypeEnum: string
{
    case NUMERIC = 'numeric';
    case STRING = 'string';
    case BOOLEAN = 'boolean';
    case LIST = 'list';
}
