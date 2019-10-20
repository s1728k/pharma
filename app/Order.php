<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_no', 'order_date', 'due_date_req', 'due_date', 'pterms', 'order_ref_no', 'customer_id', 'order_to', 'iaddress', 
        'iemail', 'iphone', 'ship_to', 'saddress', 'discount_rate', 'tax1_rate', 'tax2_rate', 'extra_cost_name', 'extra_cost', 'template', 
        'sales_person', 'category', 'status', 'emailed_on', 'printed_on', 'sms_on', 'sum', 'sumt1', 'sumt2', 'discount', 'subtotal', 
        'tax1', 'tax2', 'order_total','total_paid', 'balance', 'title_text','page_header_text', 'footer_text', 'comments','terms', 'private_notes',
    ];

}
