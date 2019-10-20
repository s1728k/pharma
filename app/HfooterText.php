<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HfooterText extends Model
{
    public $table = 'hfooter_text';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hf_text',
    ];

}
