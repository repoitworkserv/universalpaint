<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_title',
        'post_name',
        'post_content',
    ];
	public function PostMetaData(){
    	return $this->hasMany('App\PostMetaData', 'source_id', 'id');
    }
	
	public function GetMetaData($m_key = '', $s_type = ''){
    	return $this->hasMany('App\PostMetaData', 'source_id', 'id')->where('meta_key', $m_key)->where('source_type', $s_type)->first();
    }
	
	
}
