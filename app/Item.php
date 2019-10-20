<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $table = 'items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pid', 'doc_ref_no', 'code', 'product', 'description', 'unit_price', 'quantity', 'weight', 'tax1_rate', 'tax2_rate', 'price',
    ];

}
