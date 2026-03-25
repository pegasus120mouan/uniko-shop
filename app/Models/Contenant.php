<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenant extends Model
{
    protected $table = 'contenants';

    const TYPE_CLASSICS = 'classics';
    const TYPE_LUXE = 'luxe';

    protected $fillable = [
        'ml',
        'type_contenant',
        'type',
        'prix',
    ];

    protected $casts = [
        'ml' => 'integer',
        'prix' => 'integer',
    ];
}
