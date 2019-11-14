<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddSites extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category', 'industry', 'plan', 'site_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'VIEW_ID'
    ];
}
