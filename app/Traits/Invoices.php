<?php

namespace App\Traits;

use App\Item;
use App\Product;
use App\Setting;
use App\Invoice;
use App\InvoicePayment;
use App\ExtraCost;
use App\HfooterText;
use App\PaymentTerm;
use App\Customer;

use Illuminate\Http\Request;

trait Invoices
{
	public function invoiceList(Request $request)
    {
        $setting = Setting::findOrFail(1);
        $invoices = Invoice::query();
        if($request->query('category') == 'UnCategorized'){
        }else{
            $invoices = $request->query('category')?$invoices->where('category','LIKE','%'.$request->query('category').'%'):$invoices;
        }
        if($request->query('df') && $request->query('fdate') && $request->query('tdate') ){
            $invoices = $invoices->whereBetween('invoice_date',[$request->query('fdate'),$request->query('tdate')]);
        }
        $count = $invoices->count();
        $it = $invoices->sum('invoice_total');
        $tp = $invoices->sum('total_paid');
        $bl = $invoices->sum('balance');
        $invoices = $invoices->latest()->paginate(10);
        $categories = Invoice::groupBy('category')->pluck('category');
        return view("invoice_list")->with(["invoices"=>$invoices,'categories'=>$categories,'count'=>$count,'setting'=>$setting,'it'=>$it,'tp'=>$tp,'bl'=>$bl,
            'category'=>$request->query('category'),'fdate'=>$request->query('fdate'),'tdate'=>$request->query('tdate'),'df'=>$request->query('df')]);
    }

    public function recurringInvoiceList(Request $request)
    {
        \Log::Info('recurringInvoiceList');
        $setting = Setting::findOrFail(1);
        $invoices = Invoice::where('recurring',1);
        if($request->query('category') == 'UnCategorized'){
        }else{
            $invoices = $request->query('category')?$invoices->where('category','LIKE','%'.$request->query('category').'%'):$invoices;
        }
        if($request->query('df') && $request->query('fdate') && $request->query('tdate') ){
            $invoices = $invoices->whereBetween('invoice_date',[$request->query('fdate'),$request->query('tdate')]);
        }
        $count = $invoices->count();
        $it = $invoices->sum('invoice_total');
        $invoices = $invoices->latest()->paginate(10);
        $categories = Invoice::groupBy('category')->pluck('category');
        return view("recurring_list")->with(["invoices"=>$invoices,'categories'=>$categories,'count'=>$count,'setting'=>$setting,'it'=>$it,
            'category'=>$request->query('category'),'fdate'=>$request->query('fdate'),'tdate'=>$request->query('tdate'),'df'=>$request->query('df')]);
    }

    public function newInvoiceRecurring()
    {
        $setting = Setting::findOrFail(1);
        $invoice = Invoice::create(['invoice_date'=>date('Y-m-d'),'due_date'=>date('Y-m-d'),'recurring'=>1,'recurring_unit'=>1,'recurring_period'=>1,
            'tax1_rate'=>$setting->tax1_rate,'tax2_rate'=>$setting->tax2_rate]);
        $invoice_no = $setting->invoice_prefix;
        if($setting->invoice_lzcy){
            $invoice_no = $invoice_no . sprintf("%07d", $setting->starting_invoice_no + $invoice->id - 1);
            $invoice_no = $invoice_no . '/'.date("Y");
        }else{
            $invoice_no = $invoice_no . ($setting->starting_invoice_no + $invoice->id - 1);
        }
        $invoice->update(['invoice_no'=>$invoice_no]);
        $invoice->save();
        return $invoice->id;
    }

    public function newInvoiceView()
    {
        $setting = Setting::findOrFail(1);
        $invoice = Invoice::create(['status'=>'Draft','invoice_date'=>date('Y-m-d'),'due_date'=>date('Y-m-d'),'tax1_rate'=>$setting->tax1_rate,'tax2_rate'=>$setting->tax2_rate]);
        $invoice_no = $setting->invoice_prefix;
        if($setting->invoice_lzcy){
            $invoice_no = $invoice_no . sprintf("%07d", $setting->starting_invoice_no + $invoice->id - 1);
            $invoice_no = $invoice_no . '/'.date("Y");
        }else{
            $invoice_no = $invoice_no . ($setting->starting_invoice_no + $invoice->id - 1);
        }
        $invoice->update(['invoice_no'=>$invoice_no]);
        $invoice->save();
        return $invoice->id;
    }

    public function addInvoiceView($id)
    {
        $setting = Setting::findOrFail(1);
        $invoice = Invoice::findOrFail($id);
        $payments = InvoicePayment::where('invoice_id',$id)->get();
        $extra_costs = ExtraCost::all();
        $hfooters = HfooterText::all();
        $pterms = PaymentTerm::all();
        $customers = Customer::latest()->paginate(10);
        $items = Item::where('doc_ref_no','I'.$invoice->id)->get();
        
        return view("create.invoice")->with(['i'=>$invoice,'items'=>$items,'setting'=>$setting,'customers'=>$customers,
            'extra_costs'=>$extra_costs,'hfooters'=>$hfooters,'pterms'=>$pterms,'payments'=>$payments]);
    }

    public function saveInvoice(Request $request)
    {
        \Log::Info('saveInvoice');
        $in = ['invoice_no', 'invoice_date', 'due_date_req', 'due_date', 'pterms', 'order_ref_no', 'customer_id', 'invoice_to', 'iaddress', 
        'iemail', 'iphone', 'ship_to', 'saddress', 'discount_rate', 'tax1_rate', 'tax2_rate', 'extra_cost_name', 'extra_cost', 'template', 
        'sales_person', 'category', 'status', 'emailed_on', 'printed_on', 'sms_on','discount','subtotal','tax1','tax2','invoice_total','total_paid',
        'balance', 'recurring', 'recurring_period', 'recurring_unit', 'next_invoice', 'stop_recurring_after', 'stop_recurring_after2', 'title_text', 
        'page_header_text', 'footer_text', 'comments', 'terms', 'private_notes', ];
        $invld = ['string|max:32', 'date', 'boolean', 'date', 'string|max:32', 'string|max:32', 'string|max:32', 'numeric', 'string|max:1000', 
        'string|max:70', 'string|max:15', 'string|max:32', 'string|max:1000', 'numeric|non_fraction|tinyInteger', 'numeric|non_fraction|tinyInteger', 'numeric|non_fraction|tinyInteger', 'string|max:255', 'numeric|non_fraction|smallIntegerUnsigned', 'string|max:255', 
        'string|max:32', 'string|max:32', 'string|max:20', 'date', 'date', 'date','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2', 'boolean', 'numeric|non_fraction|tinyInteger', 'numeric|non_fraction|tinyInteger', 'date', 'numeric|non_fraction|tinyInteger', 'date', 'string|max:255', 'string|max:255', 
        'string|max:255', 'string|max:65536', 'string|max:65536', 'string|max:65536', ];
        $i=0;
        foreach ($in as $inv) {
            if(isset($request->{$inv})){
                $request->validate([$inv => $invld[$i]]);
                if(isset($request->id)){
                    if($inv == 'invoice_to'){
                        $c = Customer::findOrFail($request->{$inv});
                        Invoice::findOrFail($request->id)->update(['customer_id'=>$c->customer_id,'invoice_to'=>$c->bname,'iaddress'=>$c->baddress,'iemail'=>$c->bemail,'iphone'=>$c->bmobile, 'ship_to'=>$c->sname,'saddress'=>$c->saddress,'discount_rate'=>$c->discount,'tax1_rate'=>$c->tax1_rate,'tax2_rate'=>$c->tax2_rate]);
                        $this->calcSummary(0,$request->id);
                        return $request->id;
                    }else{
                        Invoice::findOrFail($request->id)->update([$inv => $request->{$inv}]);
                        if(in_array($inv,['discount_rate', 'tax1_rate', 'tax2_rate', 'extra_cost'])){
                            $this->calcSummary(0,$request->id);
                            return $request->id;
                        }
                        if($inv == 'extra_cost_name'){
                            return $request->id;
                        }
                    }
                }
                return 0;
            }
            $i++;
        }
        return 0;
    }

    public function deleteInvoices(Request $request)
    {
        foreach ($request->items as $id) {
            $items = Item::where('doc_ref_no','I'.$id)->get();
            foreach ($items as $item) {
                $p = Product::findOrFail($item->pid);
                $p->update(['stock' => $p->stock + $item->quantity]);
                $p->save();
            }
            Invoice::destroy($id);
        }
        return 0;
    }

    public function addPayment(Request $request)
    {
        $request->validate(['invoice_id'=>'numeric','payment_date'=>'date','paid_by'=>'string|max:32','description'=>'string|max:255','amount'=>'decimal:8,2']);
        InvoicePayment::create($request->all());
        $invoice = Invoice::findOrFail($request->invoice_id);
        $invoice->update(['total_paid'=>$invoice->total_paid + $request->amount]);
        $invoice->update(['balance'=>$invoice->invoice_total - $invoice->total_paid]);
        $invoice->save();
        return 0;
    }

}