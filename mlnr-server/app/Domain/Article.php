<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $table = 'article';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'published', 'text', 'title', 'access',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function author()
    {
        return $this->belongsTo('App\Domain\User');
    }
}
