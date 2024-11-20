<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    use HasFactory;

    const WEDDING_EVENT_ID = 1;
    const BIRTHDAY_EVENT_ID = 2;
}
