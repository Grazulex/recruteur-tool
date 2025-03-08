<?php

namespace App\Enums;

enum GroupType: string
{
    case AGENCY = 'agency';
    case COMPANY = 'company';

    public function getLabel(): string
    {
        return match ($this) {
            self::AGENCY => 'Agency',
            self::COMPANY => 'Company',
        };
    }
}
