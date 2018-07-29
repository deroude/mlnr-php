<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class RSVP extends Model
{

    protected $table='rsvp';
    
    public static $ANSWERS = ['YES', 'NO', 'MAYBE'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer', 'text', 'secret'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function meeting()
    {
        return $this->belongsTo('App\Domain\Meeting');
    }

    public function user()
    {
        return $this->hasOne('App\Domain\User');
    }
}
