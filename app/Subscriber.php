<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'subscriber';
	
	protected $fillable = [
		'email_address',
		'is_subscribe'
    ];
}
