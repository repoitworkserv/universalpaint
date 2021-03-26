<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HowToPaintContent extends Model
{
    protected $table = 'how_to_paint_contents';

    protected $fillable = [
        'how_to_paint_id',
        'content',
        'image',
        'status',
        'created_at',
        'updated_at'
    ];
}
