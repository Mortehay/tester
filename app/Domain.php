<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{

    protected $table = 'domains';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'link', 'hosting_name', 'hosting_link', 'type', 'login', 'password', 'description'
    ];

    public function addDomains()
    {
        return $this->hasMany('App\AddDomain', 'id' );
    }

    public function screen()
    {
        return $this->hasOne('App\ImageUploads','domain_id','id' );
    }
}
