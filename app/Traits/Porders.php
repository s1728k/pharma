<?php

namespace App\Traits;

use App\Item;
use App\Product;
use App\Setting;
use App\Porder;
use App\PorderPayment;
use App\ExtraCost;
use App\HfooterText;
use App\PaymentTerm;
use App\Customer;

use Illuminate\Http\Request;

trait Porders
{
	public function porderList(Request $request)
    {
        $setting = Setting::findOrFail(1);
        $porders = Porder::query();
        if($request->query('category') == 'UnCategorized'){
        }else{
            $porders = $request->query('category')?$porders->where('category','LIKE','%'.$request->query('category').'%'):$porders;
        }
        if($request->query('df') && $request->query('fdate') && $request->query('tdate') ){
            $porders = $porders->whereBetween('porder_date',[$request->query('fdate'),$request->query('tdate')]);
        }
        $count = $porders->count();
        $it = $porders->sum('porder_total');
        $porders = $porders->latest()->paginate(10);
        $categories = Porder::groupBy('category')->pluck('category');
        return view("porder_list")->with(["porders"=>$porders,'categories'=>$categories,'count'=>$count,'setting'=>$setting,'it'=>$it,
            'category'=>$request->query('category'),'fdate'=>$request->query('fdate'),'tdate'=>$request->query('tdate'),'df'=>$request->query('df')]);
    }

    public function newPorderView()
    {
        $setting = Setting::findOrFail(1);
        $porder = Porder::create(['status'=>'Draft','porder_date'=>date('Y-m-d'),'due_date'=>date('Y-m-d'),'tax1_rate'=>$setting->tax1_rate,'tax2_rate'=>$setting->tax2_rate]);
        $porder_no = $setting->porder_prefix;
        if($setting->porder_lzcy){
            $porder_no = $porder_no . sprintf("%07d", $setting->starting_porder_no + $porder->id - 1);
            $porder_no = $porder_no . '/'.date("Y");
        }else{
            $porder_no = $porder_no . ($setting->starting_porder_no + $porder->id - 1);
        }
        $porder->update(['porder_no'=>$porder_no]);
        $porder->save();
        return $porder->id;
    }

    public function addPorderView($id)
    {
        $setting = Setting::findOrFail(1);
        $porder = Porder::findOrFail($id);
        $extra_costs = ExtraCost::all();
        $hfooters = HfooterText::all();
        $pterms = PaymentTerm::all();
        $customers = Customer::latest()->paginate(10);
        $items = Item::where('doc_ref_no','P'.$porder->id)->get();
        
        return view("create.porder")->with(['i'=>$porder,'items'=>$items,'setting'=>$setting,'customers'=>$customers,
            'extra_costs'=>$extra_costs,'hfooters'=>$hfooters,'pterms'=>$pterms]);
    }

    public function savePorder(Request $request)
    {
        \Log::Info('savePorder');
        $in = ['porder_no', 'porder_date', 'due_date_req', 'due_date', 'pterms', 'order_ref_no', 'vendor_id', 'vendor', 'vaddress', 
        'vemail', 'vphone', 'delivery_to', 'daddress', 'discount_rate', 'tax1_rate', 'tax2_rate', 'extra_cost_name', 'extra_cost', 'template', 
        'sales_person', 'category', 'status', 'emailed_on', 'printed_on', 'sms_on', 'discount', 'subtotal', 
        'tax1', 'tax2', 'porder_total','title_text', 'page_header_text', 'footer_text','comments', 'terms', 'private_notes', ];
        $invld = ['string|max:32', 'date', 'boolean', 'date', 'string|max:32', 'string|max:32', 'numeric|non_fraction|integer_custom_unsigned', 
        'string|max:32', 'string|max:1000', 
        'string|max:70', 'string|max:15', 'string|max:32', 'string|max:1000', 'numeric|non_fraction|tinyInteger', 'numeric|non_fraction|tinyInteger', 'numeric|non_fraction|tinyInteger', 'string|max:255', 'numeric|non_fraction|smallIntegerUnsigned', 'string|max:255', 
        'string|max:32', 'string|max:32', 'string|max:20', 'date', 'date', 'date','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','string|max:255', 'string|max:255', 
        'string|max:255', 'string|max:65536', 'string|max:65536', 'string|max:65536', ];
        $i=0;
        foreach ($in as $inv) {
            if(isset($request->{$inv})){
                $request->validate([$inv => $invld[$i]]);
                if(isset($request->id)){
                    if($inv == 'vendor'){
                        $c = Customer::findOrFail($request->{$inv});
                        Porder::findOrFail($request->id)->update(['vendor_id'=>$c->customer_id,'vendor'=>$c->bname,'vaddress'=>$c->baddress,'vemail'=>$c->bemail,'vphone'=>$c->bmobile, 'delivery_to'=>$c->sname,'daddress'=>$c->saddress,'discount_rate'=>$c->discount,'tax1_rate'=>$c->tax1_rate,'tax2_rate'=>$c->tax2_rate]);
                        $this->calcSummary(3,$request->id);
                        return $request->id;
                    }else{
                        Porder::findOrFail($request->id)->update([$inv => $request->{$inv}]);
                        if(in_array($inv,['discount_rate', 'tax1_rate', 'tax2_rate', 'extra_cost'])){
                            $this->calcSummary(3,$request->id);
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

    public function deletePorders(Request $request)
    {
        foreach ($request->items as $id) {
            Porder::destroy($id);
        }
        return 0;
    }

}