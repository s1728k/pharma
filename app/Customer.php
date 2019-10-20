<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'category', 'status', 'bname', 'baddress', 'bcontact_person', 'bemail', 'btel', 'bfax', 'bmobile', 'sname', 'saddress', 'scontact_person', 'semail', 'stel', 'sfax', 'country', 'city', 'tax_exempt', 'discount', 'tax1_rate', 'tax2_rate', 'customer_type', 'notes', 
    ];

}
