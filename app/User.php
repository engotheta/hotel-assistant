<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'gender',
        'birth',
        'phone',
        'email',
        'image',
        'password',
        'active',
        'online',
        'salary',
        'branch_id',
        'creator_id',
        'role_id',
        'address_id',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName(){
      return 'slug';
    }

    public function branch(){
      return $this->belongsTo('App\Branch');
    }

    public function pictures(){
      return $this->morphMany('App\Picture','picturable');
    }

    public function department(){
      return $this->belongsTo('App\Department');
    }

    public function role(){
      return $this->belongsTo('App\Role');
    }

    public function address(){
      return $this->belongsTo('App\Address');
    }

    public function title(){
      return $this->belongsTo('App\Title');
    }

    public function salaries(){
      return $this->hasMany('App\Salary');
    }

    public function remarks(){
      return $this->morphMany('App\Remark','remarkable');
    }

    public function loans(){
      return $this->hasMany('App\Loan');
    }
}
