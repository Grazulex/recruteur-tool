<?php

namespace App\Enums;

enum RoleUser: string
{
    case CANDIDATE = 'candidate';
    case ADMIN = 'admin';

    public function getLabel(): string
    {
        return match ($this) {
            self::CANDIDATE => 'Candidate',
            self::ADMIN => 'Admin',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::CANDIDATE => 'amber',
            self::ADMIN => 'fuchsia',
        };
    }
}
