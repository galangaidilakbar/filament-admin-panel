<?php

namespace App\Enums;

enum RoleName: string
{
    case Superintendant = 'Superintendant';
    case Manager = 'Manager';
    case Admin = 'Admin';
    case Marketing = 'Marketing';
    case Sales = 'Sales';
    case Partner = 'Partner';
    case Mitra = 'Mitra';
    case SuperAdmin = 'Super-Admin';

    public static function toArray(): array
    {
        return array_map(
            static fn (self $role): string => $role->value,
            self::cases()
        );
    }
}
