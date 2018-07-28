<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Lodge extends Model
{

    protected $table='lodge';

    public static $STATUSES = ['REGULAR', 'INACTIVE'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'orient', 'number', 'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function members()
    {
        return $this->hasMany('App\Domain\User');
    }
}
