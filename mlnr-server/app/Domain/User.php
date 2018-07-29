<?php

namespace App\Domain;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    public static $ROLES = ['USER', 'ADMIN', 'SUPERADMIN'];
    public static $RANKS = ['PROFANE', 'SEEKER', 'APPRENTICE', 'JOURNEYMAN', 'MASTER'];
    public static $ASSIGNMENTS = ['MEMBER', 'SECRETARY', 'ORATOR', 'WORSHIPFUL_MASTER', 'SENIOR_WARDEN', 'JUNIOR_WARDEN', 'DEACON', 'TREASURER', 'TYLER'];
    public static $STATUSES = ['ACTIVE', 'INACTIVE'];

    protected $table='user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'rank', 'role', 'assignment', 'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function articles()
    {
        return $this->hasMany("App\Domain\Article");
    }

    public function lodge()
    {
        return $this->belongsTo("App\Domain\Lodge");
    }
}
