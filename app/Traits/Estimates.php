<?php

namespace App\Traits;

use App\Item;
use App\Product;
use App\Setting;
use App\Invoice;
use App\Estimate;
use App\ExtraCost;
use App\HfooterText;
use App\PaymentTerm;
use App\Customer;

use Illuminate\Http\Request;

trait Estimates
{
	public function estimateList(Request $request)
    {
        $setting = Setting::findOrFail(1);
        $estimates = Estimate::query();
        if($request->query('category') == 'UnCategorized'){
        }else{
            $estimates = $request->query('category')?$estimates->where('category','LIKE','%'.$request->query('category').'%'):$estimates;
        }
        if($request->query('df') && $request->query('fdate') && $request->query('tdate') ){
            $estimates = $estimates->whereBetween('estimate_date',[$request->query('fdate'),$request->query('tdate')]);
        }
        $count = $estimates->count();
        $it = $estimates->sum('estimate_total');
        $tp = $estimates->sum('total_paid');
        $bl = $estimates->sum('balance');
        $estimates = $estimates->latest()->paginate(10);
        $categories = Estimate::groupBy('category')->pluck('category');
        return view("estimate_list")->with(["estimates"=>$estimates,'categories'=>$categories,'count'=>$count,'setting'=>$setting,'it'=>$it,'tp'=>$tp,'bl'=>$bl,
            'category'=>$request->query('category'),'fdate'=>$request->query('fdate'),'tdate'=>$request->query('tdate'),'df'=>$request->query('df')]);
    }

    public function newEstimateView()
    {
        $setting = Setting::findOrFail(1);
        $estimate = Estimate::create(['status'=>'Draft','estimate_date'=>date('Y-m-d'),'due_date'=>date('Y-m-d'),'tax1_rate'=>$setting->tax1_rate,'tax2_rate'=>$setting->tax2_rate]);
        $estimate_no = $setting->estimate_prefix;
        if($setting->estimate_lzcy){
            $estimate_no = $estimate_no . sprintf("%07d", $setting->starting_estimate_no + $estimate->id - 1);
            $estimate_no = $estimate_no . '/'.date("Y");
        }else{
            $estimate_no = $estimate_no . ($setting->starting_estimate_no + $estimate->id - 1);
        }
        $estimate->update(['estimate_no'=>$estimate_no]);
        $estimate->save();
        return $estimate->id;
    }

    public function addEstimateView($id)
    {
        $setting = Setting::findOrFail(1);
        $estimate = Estimate::findOrFail($id);
        $extra_costs = ExtraCost::all();
        $hfooters = HfooterText::all();
        $pterms = PaymentTerm::all();
        $customers = Customer::latest()->paginate(10);
        $items = Item::where('doc_ref_no','E'.$estimate->id)->get();

        \Log::Info($estimate);
        
        return view("create.estimate")->with(['i'=>$estimate,'items'=>$items,'setting'=>$setting,'customers'=>$customers,
            'extra_costs'=>$extra_costs,'hfooters'=>$hfooters,'pterms'=>$pterms]);
    }

    public function saveEstimate(Request $request)
    {
        \Log::Info('saveEstimate');
        $in = ['estimate_no', 'estimate_date', 'due_date_req', 'due_date', 'pterms', 'order_ref_no', 'customer_id', 'estimate_to', 'iaddress', 
        'iemail', 'iphone', 'ship_to', 'saddress', 'discount_rate', 'tax1_rate', 'tax2_rate', 'extra_cost_name', 'extra_cost', 'template', 
        'sales_person', 'category', 'status', 'emailed_on', 'printed_on', 'sms_on', 'discount', 'subtotal', 
        'tax1', 'tax2', 'estimate_total','total_paid', 'balance', 'title_text','page_header_text', 'footer_text', 'comments','terms', 'private_notes', ];
        $invld = ['string|max:32', 'date', 'boolean', 'date', 'string|max:32', 'string|max:32', 'string|max:32', 'string|max:32', 'string|max:1000', 
        'string|max:70', 'string|max:15', 'string|max:32', 'string|max:1000', 'numeric|non_fraction|tinyInteger', 'numeric|non_fraction|tinyInteger', 'numeric|non_fraction|tinyInteger', 'string|max:255', 'numeric|non_fraction|smallIntegerUnsigned', 'string|max:255', 
        'string|max:32', 'string|max:32', 'string|max:20', 'date', 'date', 'date','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2', 'string|max:255', 'string|max:255', 
        'string|max:255', 'string|max:65536', 'string|max:65536', 'string|max:65536', ];
        $i=0;
        foreach ($in as $inv) {
            if(isset($request->{$inv})){
                $request->validate([$inv => $invld[$i]]);
                if(isset($request->id)){
                    if($inv == 'estimate_to'){
                        $c = Customer::findOrFail($request->{$inv});
                        Estimate::findOrFail($request->id)->update(['customer_id'=>$c->customer_id,'estimate_to'=>$c->bname,'iaddress'=>$c->baddress,'iemail'=>$c->bemail,'iphone'=>$c->bmobile, 'ship_to'=>$c->sname,'saddress'=>$c->saddress,'discount_rate'=>$c->discount,'tax1_rate'=>$c->tax1_rate,'tax2_rate'=>$c->tax2_rate]);
                        $this->calcSummary(2,$request->id);
                        return $request->id;
                    }else{
                        Estimate::findOrFail($request->id)->update([$inv => $request->{$inv}]);
                        if(in_array($inv,['discount_rate', 'tax1_rate', 'tax2_rate', 'extra_cost'])){
                            $this->calcSummary(2,$request->id);
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

    public function deleteEstimates(Request $request)
    {
        foreach ($request->items as $id) {
            Estimate::destroy($id);
        }
        return 0;
    }

    public function convertEstimateToInvoice(Request $request)
    {
        \Log::Info($request->id);
        $estimate = Estimate::findOrFail($request->id);
        $invoice = Invoice::create($estimate->toArray());

        $setting = Setting::findOrFail(1);
        $invoice_no = $setting->invoice_prefix;
        if($setting->invoice_lzcy){
            $invoice_no = $invoice_no . sprintf("%07d", $setting->starting_invoice_no + $invoice->id - 1);
            $invoice_no = $invoice_no . '/'.date("Y");
        }else{
            $invoice_no = $invoice_no . ($setting->starting_invoice_no + $invoice->id - 1);
        }

        $invoice->update(['invoice_no'=>$invoice_no,'order_ref_no'=>$estimate->estimate_no,'invoice_to'=>$estimate->estimate_to,'invoice_total'=>$estimate->estimate_total]);
        $invoice->save();
        $items = Item::where('doc_ref_no','E'.$estimate->id)->get();
        foreach ($items as $item) {
            $p = Product::findOrFail($item->pid);
            $i = Item::create($item->toArray());
            $i->update(['doc_ref_no'=>'I'.$invoice->id]);
            $i->save();
            if($p->service == 0){
                $p->update(['stock'=>$p->stock-$item->quantity]);
                $p->save();
            }
        }
        return $invoice->id;
    }

}