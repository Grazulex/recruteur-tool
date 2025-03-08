<?php

namespace App\Enums;

enum GroupType: string
{
    case CANDIDATE = 'candidate';
    case AGENCY = 'agency';
    case COMPANY = 'company';

    public function getLabel(): string
    {
        return match ($this) {
            self::CANDIDATE => 'Candidate',
            self::AGENCY => 'Agency',
            self::COMPANY => 'Company',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::CANDIDATE => 'red',
            self::AGENCY => 'blue',
            self::COMPANY => 'green',
        };
    }
}
