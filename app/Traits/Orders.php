<?php

namespace App\Traits;

use App\Item;
use App\Product;
use App\Setting;
use App\Order;
use App\Invoice;
use App\ExtraCost;
use App\HfooterText;
use App\PaymentTerm;
use App\Customer;

use Illuminate\Http\Request;

trait Orders
{
	public function orderList(Request $request)
    {
        $setting = Setting::findOrFail(1);
        $orders = Order::query();
        if($request->query('category') == 'UnCategorized'){
        }else{
            $orders = $request->query('category')?$orders->where('category','LIKE','%'.$request->query('category').'%'):$orders;
        }
        if($request->query('df') && $request->query('fdate') && $request->query('tdate') ){
            $orders = $orders->whereBetween('order_date',[$request->query('fdate'),$request->query('tdate')]);
        }
        $count = $orders->count();
        $it = $orders->sum('order_total');
        $tp = $orders->sum('total_paid');
        $bl = $orders->sum('balance');
        $orders = $orders->latest()->paginate(10);
        $categories = Order::groupBy('category')->pluck('category');
        return view("order_list")->with(["orders"=>$orders,'categories'=>$categories,'count'=>$count,'setting'=>$setting,'it'=>$it,'tp'=>$tp,'bl'=>$bl,
            'category'=>$request->query('category'),'fdate'=>$request->query('fdate'),'tdate'=>$request->query('tdate'),'df'=>$request->query('df')]);
    }

    public function newOrderView()
    {
        $setting = Setting::findOrFail(1);
        $order = Order::create(['status'=>'Draft','order_date'=>date('Y-m-d'),'due_date'=>date('Y-m-d'),'tax1_rate'=>$setting->tax1_rate,'tax2_rate'=>$setting->tax2_rate]);
        $order_no = $setting->order_prefix;
        if($setting->order_lzcy){
            $order_no = $order_no . sprintf("%07d", $setting->starting_order_no + $order->id - 1);
            $order_no = $order_no . '/'.date("Y");
        }else{
            $order_no = $order_no . ($setting->starting_order_no + $order->id - 1);
        }
        $order->update(['order_no'=>$order_no]);
        $order->save();
        return $order->id;
    }

    public function addOrderView($id)
    {
        $setting = Setting::findOrFail(1);
        $order = Order::findOrFail($id);
        $extra_costs = ExtraCost::all();
        $hfooters = HfooterText::all();
        $pterms = PaymentTerm::all();
        $customers = Customer::latest()->paginate(10);
        $items = Item::where('doc_ref_no','R'.$order->id)->get();
        
        return view("create.order")->with(['i'=>$order,'items'=>$items,'setting'=>$setting,'customers'=>$customers,
            'extra_costs'=>$extra_costs,'hfooters'=>$hfooters,'pterms'=>$pterms]);
    }

    public function saveOrder(Request $request)
    {
        \Log::Info('saveOrder');
        $in = ['order_no', 'order_date', 'due_date_req', 'due_date', 'pterms', 'order_ref_no', 'customer_id', 'order_to', 'iaddress', 
        'iemail', 'iphone', 'ship_to', 'saddress', 'discount_rate', 'tax1_rate', 'tax2_rate', 'extra_cost_name', 'extra_cost', 'template', 
        'sales_person', 'category', 'status', 'emailed_on', 'printed_on', 'sms_on', 'discount', 'subtotal', 
        'tax1', 'tax2', 'order_total','total_paid', 'balance', 'title_text','page_header_text', 'footer_text', 'comments','terms', 'private_notes', ];
        $invld = ['string|max:32', 'date', 'boolean', 'date', 'string|max:32', 'string|max:32', 'string|max:32', 'string|max:32', 'string|max:1000', 
        'string|max:70', 'string|max:15', 'string|max:32', 'string|max:1000', 'numeric|non_fraction|tinyInteger', 'numeric|non_fraction|tinyInteger', 'numeric|non_fraction|tinyInteger', 'string|max:255', 'numeric|non_fraction|smallIntegerUnsigned', 'string|max:255', 
        'string|max:32', 'string|max:32', 'string|max:20', 'date', 'date', 'date','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2','numeric|decimal:8,2', 'string|max:255', 'string|max:255', 
        'string|max:255', 'string|max:65536', 'string|max:65536', 'string|max:65536', ];
        $i=0;
        foreach ($in as $inv) {
            if(isset($request->{$inv})){
                $request->validate([$inv => $invld[$i]]);
                if(isset($request->id)){
                    if($inv == 'order_to'){
                        $c = Customer::findOrFail($request->{$inv});
                        Order::findOrFail($request->id)->update(['customer_id'=>$c->customer_id,'order_to'=>$c->bname,'iaddress'=>$c->baddress,'iemail'=>$c->bemail,'iphone'=>$c->bmobile, 'ship_to'=>$c->sname,'saddress'=>$c->saddress,'discount_rate'=>$c->discount,'tax1_rate'=>$c->tax1_rate,'tax2_rate'=>$c->tax2_rate]);
                        $this->calcSummary(1,$request->id);
                        return $request->id;
                    }else{
                        Order::findOrFail($request->id)->update([$inv => $request->{$inv}]);
                        if(in_array($inv,['discount_rate', 'tax1_rate', 'tax2_rate', 'extra_cost'])){
                            $this->calcSummary(1,$request->id);
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

    public function deleteOrders(Request $request)
    {
        foreach ($request->items as $id) {
            Order::destroy($id);
        }
        return 0;
    }

    public function convertOrderToInvoice(Request $request)
    {
        \Log::Info($request->id);
        $order = Order::findOrFail($request->id);
        $invoice = Invoice::create($order->toArray());

        $setting = Setting::findOrFail(1);
        $invoice_no = $setting->invoice_prefix;
        if($setting->invoice_lzcy){
            $invoice_no = $invoice_no . sprintf("%07d", $setting->starting_invoice_no + $invoice->id - 1);
            $invoice_no = $invoice_no . '/'.date("Y");
        }else{
            $invoice_no = $invoice_no . ($setting->starting_invoice_no + $invoice->id - 1);
        }

        $invoice->update(['invoice_no'=>$invoice_no,'order_ref_no'=>$order->order_no,'invoice_to'=>$order->order_to,'invoice_total'=>$order->order_total]);
        $invoice->save();
        $items = Item::where('doc_ref_no','R'.$order->id)->get();
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