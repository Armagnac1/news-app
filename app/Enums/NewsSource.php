<?php

namespace App\Enums;

enum NewsSource: string
{
    case SPACEFLIGHT = 'spaceflight';
    case GNEWS = 'gnews';

    public function label(): string
    {
        return match ($this) {
            self::SPACEFLIGHT => 'Spaceflight News API',
            self::GNEWS => 'GNews',
        };
    }

    public function baseUrl(): string
    {
        return match ($this) {
            self::SPACEFLIGHT => 'https://api.spaceflightnewsapi.net/v4',
            self::GNEWS => 'https://gnews.io/api/v4',
        };
    }
}
