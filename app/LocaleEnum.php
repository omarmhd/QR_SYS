<?php

namespace App;

enum LocaleEnum: string
{
    case EN = 'en'; // English
    case RO = 'ro'; // Romanian
 public function label(): string
    {
        return match ($this) {
            self::EN => 'English',
            self::RO => 'Română',
        };
    }
}
