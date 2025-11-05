<?php

namespace App\Enum;

enum RoomType: string
{
    case SINGLE = 'single';
    case DOUBLE = 'double';
    case SUITE = 'suite';
}
