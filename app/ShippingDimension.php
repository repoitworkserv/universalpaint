<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingDimension extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shipping_dimension';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'size',
        'length',
        'width',
        'height',
        'weight
        '
    ];
}
