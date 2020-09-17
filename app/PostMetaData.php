<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMetaData extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_metadata';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'meta_key',
        'meta_value',
        'meta_type',
        'source_type',
    ];
	
	public function PostData(){
    	return $this->hasOne('App\Post', 'id', 'source_id');
    }
}
