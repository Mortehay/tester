<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageUploads extends Model
{
    protected $table = 'image_uploads';

    protected $fillable = [
        'domain_id',
        'image_path'
    ];

    public function domain()
    {
        return $this->belongsTo('App\Domain','domain_id');
    }
}
