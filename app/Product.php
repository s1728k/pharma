<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'category', 'status', 'name', 'description', 'unit_price', 'cost', 'weight', 'tax1_rate', 
        'tax2_rate', 'service', 'stock', 'low_stock_warning_limit', 'warehouse', 'notes',
    ];

}
