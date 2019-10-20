<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $table = 'documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'doc_ref_no', 'file_name', 'file_size', 'file_path', 
    ];

}
