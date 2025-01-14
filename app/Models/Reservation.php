<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer',
        'totalperson',
        'packagechoice',
        'date',
        'pickup',
        'email',
        'phonenumber',
        'status'
    ];
}