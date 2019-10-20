<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public $table = 'expenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'date', 'vendor', 'category', 'description', 'staff_member', 'tax1', 'tax2', 'assign_to_customer', 'customer_name', 'rebillable', 'code', 'rebill_amount', 'attach_receipt_image', 'receipt_image', 'notes',
    ];

}
