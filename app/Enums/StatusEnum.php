<?php
namespace App\Enums;

enum StatusEnum: string{
    case Open = 'open';
    case Completed = 'completed';
    case InProgress = 'in progress';
    case Blocked = 'blocked';
    case Cancelled = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}