<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportLabel extends Model
{
    public $table = 'report_labels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'default', 'custom',
    ];

}
