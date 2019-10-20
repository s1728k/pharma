<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommonMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->users_table();
        $this->password_reset_table();
        $this->extra_cost_table();
        $this->hfooter_text_table();
        $this->terms_of_payment_table();
        $this->report_labels_table();
        $this->settings_table();
        $this->products_table();
        $this->customers_table();
        $this->invoices_table();
        $this->items_table();
        $this->invoice_payments_table();
        $this->documents_table();
        $this->orders_table();
        $this->estimates_table();
        $this->porders_table();
        $this->expenses_table();
        $this->main_category_table();
        $this->sub_category_table();
        $this->drugs_table();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('users');
        // Schema::dropIfExists('password_resets');
        // Schema::dropIfExists('drugs_table');
        // Schema::dropIfExists('sub_category_table');
        // Schema::dropIfExists('main_category_table');
        // $tables = ['users','password_resets','extra_cost','hfooter_text','terms_of_payment','report_labels','settings','products','customers','invoices','items','invoice_payments','documents','orders','estimates','porders','expenses','main_category_table','sub_category_table','drugs_table'];
        $tables = ['expenses'];
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }

    public function users_table()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function password_reset_table()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function extra_cost_table()
    {
        Schema::create('extra_cost', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        $extra_costs = ['Shipping and handling','Postage and handling','Delivery cost'];

        $table = "App\\ExtraCost";
        foreach ($extra_costs as $extra_cost) {
            $table::create(["name" => $extra_cost]);
        }
    }

    public function hfooter_text_table()
    {
        Schema::create('hfooter_text', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hf_text')->nullable();
            $table->timestamps();
        });

        $hftexts = ['Thank you for your purchase!','Thank you for buying!','Thank you for your businnes!','Thank you for your order!'];

        $table = "App\\HfooterText";
        foreach ($hftexts as $hftext) {
            $table::create(["hf_text" => $hftext]);
        }
    }

    public function terms_of_payment_table()
    {
        Schema::create('terms_of_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pterm')->nullable();
            $table->unsignedTinyInteger('shift')->nullable();
            $table->timestamps();
        });

        $pterms = ['Cash on delivery','Credit card','NET 07','NET 10','NET 14','NET 20','NET 30'];
        $shifts = [0,0,7,10,14,20,30];
        $i=0;

        $table = "App\\PaymentTerm";
        foreach ($pterms as $pterm) {
            $table::create(["pterm" => $pterm,'shift'=>$shifts[$i]]);
            $i=$i+1;
        }
    }

    public function report_labels_table()
    {
        Schema::create('report_labels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('default',50)->nullable();
            $table->string('custom',50)->nullable();
            $table->timestamps();
        });

        $labels = ['Invoice','Invoice#','Invoice date','Due date','Order ref.#','Terms','Bill to','Ship to','ID/SKU','Product/Service','Quantity','Description','Unit Price','Price','Subtotal','Discount','Discount rate','TAX1','TAX2','Invoice total','Total Paid','Balance','Terms and Conditions','TAX EXEMPTED','Page','of','Order','Order#','Order date','Due date','Order To','Order total','Estimate','Estimate#','Estimate Date','Due Date','Estimate To','Estimate Total','Payment Receipt','Payment Date:','Payment for Invoice#','Payment Amount:','Amount received from:','Total Amount Due','Description:','Total Paid','Payment Received in:','Balance Due','Payment Receipt#','Purchase Order','P.ORD','P.Order Date','Due Date','Vendor','Delivery to','P.Order Total'];

        $table = "App\\ReportLabel";
        foreach ($labels as $label) {
            $table::create(["default" => $label,"custom" => $label]);
        }

    }

    public function settings_table()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('email')->nullable();
            $table->string('sales_tax_reg_no')->nullable();
            $table->text('company_logo')->nullable();
            $table->char('currency',3)->nullable();
            $table->char('currency_sign',1)->nullable();
            $table->tinyInteger('currency_sign_placement')->nullable();
            $table->char('decimal',1)->nullable();
            $table->tinyInteger('tax_type')->nullable();
            $table->string('tax1_name', 32)->nullable();
            $table->tinyInteger('tax1_rate')->nullable();
            $table->string('tax2_name', 32)->nullable();
            $table->tinyInteger('tax2_rate')->nullable();
            $table->boolean('print_tax1')->nullable();
            $table->boolean('print_tax2')->nullable();
            $table->boolean('tax2_type')->nullable();
            $table->boolean('print_logo_picture')->nullable();
            $table->string('invoice_prefix', 32)->nullable();
            $table->unsignedInteger('starting_invoice_no')->nullable();
            $table->boolean('invoice_lzcy')->nullable();
            $table->text('invoice_tctext')->nullable();
            $table->string('order_prefix', 32)->nullable();
            $table->unsignedInteger('starting_order_no')->nullable();
            $table->boolean('order_lzcy')->nullable();
            $table->text('order_tctext')->nullable();
            $table->string('estimate_prefix', 32)->nullable();
            $table->unsignedInteger('starting_estimate_no')->nullable();
            $table->boolean('estimate_lzcy')->nullable();
            $table->text('estimate_tctext')->nullable();
            $table->string('porder_prefix', 32)->nullable();
            $table->unsignedInteger('starting_porder_no')->nullable();
            $table->boolean('porder_lzcy')->nullable();
            $table->text('porder_tctext')->nullable();
            $table->boolean('payments1')->nullable();
            $table->boolean('payments2')->nullable();
            $table->boolean('payments3')->nullable();
            $table->boolean('payments4')->nullable();
            $table->string('payment_receipt_prefix', 32)->nullable();
            $table->text('paid_image')->nullable();
            $table->text('pay_image')->nullable();
            $table->timestamps();
        });
        $table = "App\\Setting";
        $table::create(['currency'=>'INR','currency_sign'=>'₹','currency_sign_placement'=>'0','decimal'=>'.',
            'tax_type'=>0,'tax1_name'=>'TAX1','tax1_rate'=>10,'print_tax1'=>1,'print_tax2'=>1,'print_logo_picture'=>1,
            'invoice_lzcy'=>1,'order_lzcy'=>1,'estimate_lzcy'=>1,'porder_lzcy'=>1,
            'invoice_prefix'=>'INV','order_prefix'=>'ORD','estimate_prefix'=>'EST','porder_prefix'=>'P.ORD',
            'starting_invoice_no'=>1,'starting_order_no'=>1,'starting_estimate_no'=>1,'starting_porder_no'=>1,
            'invoice_tctext'=>'Invoices are payable on receipt unless other terms, negotiated and noted on the invoice. By accepting delivery of goods, Buyer agrees to pay the invoiced cost for those goods, and agrees to be bound to these contract terms. No acceptance may vary these terms unless specifically agreed in writing by Seller.',
        ]);
    }

    public function products_table()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',32)->nullable();
            $table->string('category',120)->nullable();
            $table->boolean('status')->default(0);
            $table->string('name',180)->nullable();
            $table->string('description',1000)->nullable();
            $table->float('unit_price',8,2)->nullable();
            $table->float('cost',8,2)->nullable();
            $table->float('weight',8,2)->nullable();
            $table->tinyInteger('tax1_rate')->nullable();
            $table->tinyInteger('tax2_rate')->nullable();
            $table->boolean('service')->default(0);
            $table->unsignedInteger('stock')->nullable();
            $table->unsignedInteger('low_stock_warning_limit')->nullable();
            $table->string('warehouse',120)->nullable();
            $table->text('notes')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    public function customers_table()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_id',32)->nullable();
            $table->string('category',120)->nullable();
            $table->boolean('status')->default(0);
            $table->string('bname',100)->nullable();
            $table->string('baddress',200)->nullable();
            $table->string('bcontact_person',50)->nullable();
            $table->string('bemail',70)->nullable();
            $table->string('btel',15)->nullable();
            $table->string('bfax',15)->nullable();
            $table->string('bmobile',15)->nullable();
            $table->string('sname',100)->nullable();
            $table->string('saddress',200)->nullable();
            $table->string('scontact_person',50)->nullable();
            $table->string('semail',70)->nullable();
            $table->string('stel',15)->nullable();
            $table->string('sfax',15)->nullable();
            $table->string('country',32)->nullable();
            $table->string('city',32)->nullable();
            $table->boolean('tax_exempt')->nullable();
            $table->float('discount',8,2)->nullable();
            $table->float('tax1_rate',8,2)->nullable();
            $table->float('tax2_rate',8,2)->nullable();
            $table->tinyInteger('customer_type')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function invoices_table()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no',32)->nullable();
            $table->date('invoice_date')->nullable();
            $table->boolean('due_date_req')->nullable();
            $table->date('due_date')->nullable();
            $table->string('pterms',32)->nullable();
            $table->string('order_ref_no',32)->nullable();
            $table->string('customer_id',32)->nullable();
            $table->string('invoice_to',32)->nullable();
            $table->string('iaddress',1000)->nullable();
            $table->string('iemail',70)->nullable();
            $table->string('iphone',15)->nullable();
            $table->string('ship_to',32)->nullable();
            $table->string('saddress',1000)->nullable();
            $table->tinyInteger('discount_rate')->nullable();
            $table->tinyInteger('tax1_rate')->nullable();
            $table->tinyInteger('tax2_rate')->nullable();
            $table->string('extra_cost_name')->nullable();
            $table->unsignedSmallInteger('extra_cost')->nullable();
            $table->string('template')->nullable();
            $table->string('sales_person',32)->nullable();
            $table->string('category',32)->nullable();
            $table->string('status',20)->nullable();
            $table->date('emailed_on')->nullable();
            $table->date('printed_on')->nullable();
            $table->date('sms_on')->nullable();
            $table->float('sum',8,2)->nullable();
            $table->float('sumt1',8,2)->nullable();
            $table->float('sumt2',8,2)->nullable();
            $table->float('discount',8,2)->nullable();
            $table->float('subtotal',8,2)->nullable();
            $table->float('tax1',8,2)->nullable();
            $table->float('tax2',8,2)->nullable();
            $table->float('invoice_total',8,2)->nullable();
            $table->float('total_paid',8,2)->nullable();
            $table->float('balance',8,2)->nullable();
            $table->boolean('recurring')->nullable();
            $table->tinyInteger('recurring_period')->nullable();
            $table->tinyInteger('recurring_unit')->nullable();
            $table->date('next_invoice')->nullable();
            $table->boolean('stop_recurring_after')->nullable();
            $table->date('stop_recurring_after2')->nullable();
            $table->string('title_text')->nullable();
            $table->string('page_header_text')->nullable();
            $table->string('footer_text')->nullable();
            $table->text('comments')->nullable();
            $table->text('terms')->nullable();
            $table->text('private_notes')->nullable();
            $table->timestamps();
        });
    }

    public function items_table()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pid')->nullable();
            $table->string('doc_ref_no',32)->nullable();
            $table->string('code',32)->nullable();
            $table->string('product',180)->nullable();
            $table->string('description',1000)->nullable();
            $table->float('unit_price',8,2)->nullable();
            $table->unsignedSmallInteger('quantity')->nullable();
            $table->float('weight',8,2)->nullable();
            $table->tinyInteger('tax1_rate')->nullable();
            $table->tinyInteger('tax2_rate')->nullable();
            $table->float('price',8,2)->nullable();
            $table->timestamps();
        });
    }

    public function invoice_payments_table()
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('paid_by',32)->nullable();
            $table->string('description')->nullable();
            $table->float('amount',8,2)->nullable();
            $table->timestamps();
        });
    }

    public function documents_table()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_ref_no',32)->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function orders_table()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no',32)->nullable();
            $table->date('order_date')->nullable();
            $table->boolean('due_date_req')->nullable();
            $table->date('due_date')->nullable();
            $table->string('pterms',32)->nullable();
            $table->string('order_ref_no',32)->nullable();
            $table->string('customer_id',32)->nullable();
            $table->string('order_to',32)->nullable();
            $table->string('iaddress',1000)->nullable();
            $table->string('iemail',70)->nullable();
            $table->string('iphone',15)->nullable();
            $table->string('ship_to',32)->nullable();
            $table->string('saddress',1000)->nullable();
            $table->tinyInteger('discount_rate')->nullable();
            $table->tinyInteger('tax1_rate')->nullable();
            $table->tinyInteger('tax2_rate')->nullable();
            $table->string('extra_cost_name')->nullable();
            $table->unsignedSmallInteger('extra_cost')->nullable();
            $table->string('template')->nullable();
            $table->string('sales_person',32)->nullable();
            $table->string('category',32)->nullable();
            $table->string('status',20)->nullable();
            $table->date('emailed_on')->nullable();
            $table->date('printed_on')->nullable();
            $table->date('sms_on')->nullable();
            $table->float('sum',8,2)->nullable();
            $table->float('sumt1',8,2)->nullable();
            $table->float('sumt2',8,2)->nullable();
            $table->float('discount',8,2)->nullable();
            $table->float('subtotal',8,2)->nullable();
            $table->float('tax1',8,2)->nullable();
            $table->float('tax2',8,2)->nullable();
            $table->float('order_total',8,2)->nullable();
            $table->float('total_paid',8,2)->nullable();
            $table->float('balance',8,2)->nullable();
            $table->string('title_text')->nullable();
            $table->string('page_header_text')->nullable();
            $table->string('footer_text')->nullable();
            $table->text('comments')->nullable();
            $table->text('terms')->nullable();
            $table->text('private_notes')->nullable();
            $table->timestamps();
        });
    }

    public function estimates_table()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('estimate_no',32)->nullable();
            $table->date('estimate_date')->default(date('Y-m-d'));
            $table->boolean('due_date_req')->nullable();
            $table->date('due_date')->default(date('Y-m-d'));
            $table->string('pterms',32)->nullable();
            $table->string('order_ref_no',32)->nullable();
            $table->string('customer_id',32)->nullable();
            $table->string('estimate_to',32)->nullable();
            $table->string('iaddress',1000)->nullable();
            $table->string('iemail',70)->nullable();
            $table->string('iphone',15)->nullable();
            $table->string('ship_to',32)->nullable();
            $table->string('saddress',1000)->nullable();
            $table->tinyInteger('discount_rate')->nullable();
            $table->tinyInteger('tax1_rate')->nullable();
            $table->tinyInteger('tax2_rate')->nullable();
            $table->string('extra_cost_name')->nullable();
            $table->unsignedSmallInteger('extra_cost')->nullable();
            $table->string('template')->nullable();
            $table->string('sales_person',32)->nullable();
            $table->string('category',32)->nullable();
            $table->string('status',20)->nullable();
            $table->date('emailed_on')->nullable();
            $table->date('printed_on')->nullable();
            $table->date('sms_on')->nullable();
            $table->float('sum',8,2)->nullable();
            $table->float('sumt1',8,2)->nullable();
            $table->float('sumt2',8,2)->nullable();
            $table->float('discount',8,2)->nullable();
            $table->float('subtotal',8,2)->nullable();
            $table->float('tax1',8,2)->nullable();
            $table->float('tax2',8,2)->nullable();
            $table->float('estimate_total',8,2)->nullable();
            $table->float('total_paid',8,2)->nullable();
            $table->float('balance',8,2)->nullable();
            $table->string('title_text')->nullable();
            $table->string('page_header_text')->nullable();
            $table->string('footer_text')->nullable();
            $table->text('comments')->nullable();
            $table->text('terms')->nullable();
            $table->text('private_notes')->nullable();
            $table->timestamps();
        });
    }

    public function porders_table()
    {
        Schema::create('porders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('porder_no',32)->nullable();
            $table->date('porder_date')->default(date('Y-m-d'));
            $table->boolean('due_date_req')->nullable();
            $table->date('due_date')->default(date('Y-m-d'));
            $table->string('pterms',32)->nullable();
            $table->string('order_ref_no',32)->nullable();
            $table->string('vendor_id',32)->nullable();
            $table->string('vendor',32)->nullable();
            $table->string('vaddress',1000)->nullable();
            $table->string('vemail',70)->nullable();
            $table->string('vphone',15)->nullable();
            $table->string('delivery_to',32)->nullable();
            $table->string('daddress',1000)->nullable();
            $table->tinyInteger('discount_rate')->nullable();
            $table->tinyInteger('tax1_rate')->nullable();
            $table->tinyInteger('tax2_rate')->nullable();
            $table->string('extra_cost_name')->nullable();
            $table->unsignedSmallInteger('extra_cost')->nullable();
            $table->string('template')->nullable();
            $table->string('sales_person',32)->nullable();
            $table->string('category',32)->nullable();
            $table->string('status',20)->nullable();
            $table->date('emailed_on')->nullable();
            $table->date('printed_on')->nullable();
            $table->date('sms_on')->nullable();
            $table->float('sum',8,2)->nullable();
            $table->float('sumt1',8,2)->nullable();
            $table->float('sumt2',8,2)->nullable();
            $table->float('discount',8,2)->nullable();
            $table->float('subtotal',8,2)->nullable();
            $table->float('tax1',8,2)->nullable();
            $table->float('tax2',8,2)->nullable();
            $table->float('porder_total',8,2)->nullable();
            $table->string('title_text')->nullable();
            $table->string('page_header_text')->nullable();
            $table->string('footer_text')->nullable();
            $table->text('comments')->nullable();
            $table->text('terms')->nullable();
            $table->text('private_notes')->nullable();
            $table->timestamps();
        });
    }

    public function expenses_table()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount',8,2)->nullable();
            $table->date('date')->nullable();
            $table->string('vendor')->nullable();
            $table->string('category',100)->default('default');
            $table->string('description')->nullable();
            $table->string('staff_member')->nullable();
            $table->boolean('tax1')->nullable();
            $table->boolean('tax2')->nullable();
            $table->boolean('assign_to_customer')->nullable();
            $table->string('customer_name')->nullable();
            $table->boolean('rebillable')->nullable();
            $table->string('code',32)->nullable();
            $table->float('rebill_amount',8,2)->nullable();
            $table->boolean('attach_receipt_image')->nullable();
            $table->text('receipt_image')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function main_category_table()
    {
        Schema::create('main_category_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_id',5);
            $table->string('parent_category',10);
            $table->string('category',100);
            $table->string('url',100);
            $table->unsignedTinyInteger('no_of_sub_categories')->nullable();
            $table->timestamps();
        });
    }

    public function sub_category_table()
    {
        Schema::create('sub_category_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sub_category_id',5);
            $table->string('parent_category',10);
            $table->string('category_id',5);
            $table->string('sub_category',100);
            $table->string('url',100);
            $table->unsignedSmallInteger('no_of_drugs')->nullable();
            $table->timestamps();
        });
    }

    public function drugs_table()
    {
        Schema::create('drugs_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('drug_code',8);
            $table->string('parent_category',10);
            $table->string('category_id',5);
            $table->string('sub_category_id',5);
            $table->string('drug',100);
            $table->string('composition',1000);
            $table->string('form_of_drug',20);
            $table->string('manufacturer',70);
            $table->unsignedSmallInteger('pack_size');
            $table->unsignedMediumInteger('mrp');
            $table->string('url',100);
            $table->timestamps();
        });
    }
}

