<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table = 'site_industries';
    protected $guarded = array('id');
    public $timestamps = true;

    protected $fillable = [
        'name', 'created_at', 'updated_at'
    ];
}
