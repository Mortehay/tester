<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class AddMail extends Model
{
    protected $table = 'add_mails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_id', 'alert_mail'
    ];

    public function domain()
    {
        return $this->belongsTo('App\Domain','domain_id');
    }
}
