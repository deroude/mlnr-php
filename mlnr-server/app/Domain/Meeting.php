<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table='meeting';

    public static $TYPES = ['REGULAR', 'CASUAL', 'SUMMIT'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'location', 'text', 'type',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function rsvps()
    {
        return $this->hasMany("App\Domain\RSVP");
    }

    public function lodge()
    {
        return $this->belongsTo("App\Domain\Lodge");
    }
}
