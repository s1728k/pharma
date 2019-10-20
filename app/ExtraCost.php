<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraCost extends Model
{
    public $table = 'extra_cost';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

}
