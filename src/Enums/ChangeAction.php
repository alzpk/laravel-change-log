<?php

namespace Alzpk\LaravelChangeLog\Enums;

enum ChangeAction: string
{
    case CREATED = 'created';
    case UPDATED = 'updated';
    case DELETED = 'deleted';
}
