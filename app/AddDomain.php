<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class AddDomain extends Model
{
    protected $table = 'add_domains';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_id', 'name'
    ];

    public function domain()
    {
        return $this->belongsTo('App\Domain','domain_id');
    }
}
