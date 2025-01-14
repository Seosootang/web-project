<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CarRent extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer',
        'phonenumber',
        'carname',
        'longrent',
        'renttype',
        'rentdate',
        'finishedrent',
        'pickuptime',
        'pickuplocation',
        'email',
        'message',
        'status',
    ];
}