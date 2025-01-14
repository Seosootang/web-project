<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BusRent extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer',
        'phonenumber',
        'busname',
        'longrent',
        'bustype',
        'rentdate',
        'finishedrent',
        'departure',
        'email',
        'message',
        'status',
    ];
}