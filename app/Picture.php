<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'picture',
        'pictureable_type',
        'pictureable_id',
        'details',
        'uploader_id',
    ];

    public function picturable(){
      return $this-> morphTo();
    }
}
