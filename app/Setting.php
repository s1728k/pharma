<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name', 'company_address', 'email', 'sales_tax_reg_no', 'company_logo', 'currency', 'currency_sign', 'currency_sign_placement', 'decimal', 
        'tax_type', 'tax1_name', 'tax1_rate', 'tax2_name', 'tax2_rate', 'print_tax1', 'print_tax2', 'tax2_type', 'print_logo_picture', 'invoice_prefix', 
        'starting_invoice_no', 'invoice_lzcy', 'invoice_tctext', 'order_prefix', 'starting_order_no', 'order_lzcy', 'order_tctext', 'estimate_prefix', 
        'starting_estimate_no', 'estimate_lzcy', 'estimate_tctext', 'porder_prefix', 'starting_porder_no', 'porder_lzcy', 'porder_tctext', 'payments1', 
        'payments2', 'payments3', 'payments4', 'payment_receipt_prefix', 'paid_image', 'pay_image',
    ];

}
