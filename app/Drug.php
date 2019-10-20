<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    public $table = 'drugs_table';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'drug_code', 'parent_category', 'category_id','sub_category_id', 'drug', 'composition', 'form_of_drug', 'manufacturer','pack_size', 'mrp', 'url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
