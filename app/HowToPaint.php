<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HowToPaint extends Model
{
    protected $table = 'how_to_paint';

    protected $fillable = [
        'parent_id',
        'title',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];

    public function SubTitles(){
		return $this->hasMany('App\HowToPaint', 'parent_id', 'id');
	}
    public function Contents(){
		return $this->hasMany('App\HowToPaintContent', 'how_to_paint_id', 'id');
	}
}
