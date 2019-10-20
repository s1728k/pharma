<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Porder extends Model
{
    public $table = 'porders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'porder_no', 'porder_date', 'due_date_req', 'due_date', 'pterms', 'order_ref_no', 'vendor_id', 'vendor', 'vaddress', 
        'vemail', 'vphone', 'delivery_to', 'daddress', 'discount_rate', 'tax1_rate', 'tax2_rate', 'extra_cost_name', 'extra_cost', 'template', 
        'sales_person', 'category', 'status', 'emailed_on', 'printed_on', 'sms_on', 'sum', 'sumt1', 'sumt2', 'discount', 'subtotal', 
        'tax1', 'tax2', 'porder_total','title_text', 'page_header_text', 'footer_text','comments', 'terms', 'private_notes',
    ];

}
