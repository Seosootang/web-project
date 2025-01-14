<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image1',
        'image2',
        'image3',
        'destination1',
        'destination2',
        'destination3',
        'destination4',
        'destination5',
        'destination6',
        'destination7',
        'destination8',
        'price',
        'content',
        'status',
    ];

    protected function image1(): Attribute
    {
        return Attribute::make(
            get: fn($image1) => url('/storage/packages/' . $image1),
        );
    }

    protected function image2(): Attribute
    {
        return Attribute::make(
            get: fn($image2) => url('/storage/packages/' . $image2),
        );
    }

    protected function image3(): Attribute
    {
        return Attribute::make(
            get: fn($image3) => url('/storage/packages/' . $image3),
        );
    }
}