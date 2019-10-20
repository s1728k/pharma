<?php

namespace App\Traits;

use App\Item;
use App\Product;
use App\Setting;
use App\InvoicePayment;
use App\Customer;
use App\ReportLabel;

use Illuminate\Http\Request;

trait Common
{
	public function productFilterView(Request $request, $ind, $id)
    {
        if($ind<0 && $ind>4 || $id==0)
            return "";
        $products = Product::query();
        if($request->query('fcolumn') == 0){
            $products = $request->query('cterm')?$products->where('code','LIKE','%'.$request->query('cterm').'%'):$products;
        }elseif($request->query('fcolumn') == 1){
            $products = $request->query('cterm')?$products->where('name','LIKE','%'.$request->query('cterm').'%'):$products;
        }elseif($request->query('fcolumn') == 2){
            $products = $request->query('cterm')?$products->where('unit_price','LIKE','%'.$request->query('cterm').'%'):$products;
        }
        if($request->query('category') == 'View all records'){
        }elseif($request->query('category') == 'View all products'){
            $products = $products->where('service',0);
        }elseif($request->query('category') == 'View all services'){
            $products = $products->where('service',1);
        }else{
            $products = $request->query('category')?$products->where('category','LIKE','%'.$request->query('category').'%'):$products;
        }
        $products = $products->paginate(10);
        $categories = Product::groupBy('category')->pluck('category');

        $dict = $this->di('dic', $ind, $id);
        $record = $this->di('don', $ind, $id);
        $items_added = Item::where('doc_ref_no',$this->di('did', $ind, $id))->count();

        return view("filters.products")->with(["ind"=>$ind, "id"=>$id, "products"=>$products, 'categories'=>$categories,'dict'=>$dict,'record'=>$record,
        'items_added'=>$items_added, 'cterm'=>$request->query('cterm'),'fcolumn'=>$request->query('fcolumn'),'category'=>$request->query('category')]);
    }

    public function customerFilterView(Request $request, $ind, $id)
    {
        if($ind<0 && $ind>4 || $id==0)
            return "";
        $customers = Customer::query();
        if($request->query('fcolumn') == 0){
            $customers = $request->query('cterm')?$customers->where('customer_id','LIKE','%'.$request->query('cterm').'%'):$customers;
        }elseif($request->query('fcolumn') == 1){
            $customers = $request->query('cterm')?$customers->where('bname','LIKE','%'.$request->query('cterm').'%'):$customers;
        }elseif($request->query('fcolumn') == 2){
            $customers = $request->query('cterm')?$customers->where('btel','LIKE','%'.$request->query('cterm').'%'):$customers;
        }elseif($request->query('fcolumn') == 3){
            $customers = $request->query('cterm')?$customers->where('bcontact_person','LIKE','%'.$request->query('cterm').'%'):$customers;
        }
        if($request->query('category') == 'View all records'){
        }elseif($request->query('category') == 'View only Client type'){
            $customers = $customers->where('customer_type',0);
        }elseif($request->query('category') == 'View only Vendor type'){
            $customers = $customers->where('customer_type',1);
        }elseif($request->query('category') == 'View only Client/Vendor type'){
            $customers = $customers->where('customer_type',2);
        }else{
            $customers = $request->query('category')?$customers->where('category','LIKE','%'.$request->query('category').'%'):$customers;
        }
        $customers = $customers->paginate(10);
        $categories = Customer::groupBy('category')->pluck('category');

        $dict = $this->di('dic', $ind, $id);
        $record = $this->di('don', $ind, $id);

        return view("filters.customers")->with(["ind"=>$ind, "id"=>$id, "customers"=>$customers, 'categories'=>$categories,'dict'=>$dict,'record'=>$record,'cterm'=>$request->query('cterm'),'fcolumn'=>$request->query('fcolumn'),'category'=>$request->query('category')]);
    }

    public function printView(Request $request, $ind, $id=0)
    {
        $doc = $this->di('doc', $ind, $id);
        $setting = Setting::findOrFail(1);
        $items = Item::where('doc_ref_no',$this->di('did', $ind, $id))->get();
        $l = ReportLabel::pluck('custom');
        return view('prints.'.$this->di('dic', $ind, $id))->with(['ind'=>$ind,'id'=>$id,'d'=>$doc,'s'=>$setting,'items'=>$items,'l'=>$l]);
    }

    public function selectCustomer(Request $request, $ind, $id)
    {
        $c = Customer::findOrFail($request->customer_id);
        $record = $this->di('doc', $ind, $id);
        if($ind == 3){
            $record->update(['vendor'=>$c->bname,'vaddress'=>$c->baddress,'vemail'=>$c->bemail,'vphone'=>$c->bmobile, 'delivery_to'=>$c->sname,'daddress'=>$c->saddress,]);
        }else{
            $record->update([$this->di('dot', $ind, $id)=>$c->bname,'iaddress'=>$c->baddress,'iemail'=>$c->bemail,'iphone'=>$c->bmobile, 'ship_to'=>$c->sname,'saddress'=>$c->saddress,]);
        }
        $record->save();
        return 0;
    }

    public function calcSummary($ind, $id)
    {
        \Log::Info('calcSummary');
        $r = $this->di('doc', $ind, $id);
        $r_total = $this->di('dtl', $ind, $id);
        $s = Setting::findOrFail(1);
        $discount = -$r->sum*$r->discount_rate/100;
        $subtotal = $r->sum + $discount;
        $tax1 = $r->sumt1 * $r->tax1_rate/100;
        if($s->tax2_type == 0){
            $tax2 = $r->sumt2 * $r->tax2_rate/100;
        }else{
            $tax2 = ($r->sumt2 + $tax1) * $r->tax2_rate/100;
        }
        if($s->tax_type == 2){
            $invoice_total = $r->extra_cost + $subtotal + $tax1 + $tax2;
        }elseif($s->tax_type == 1){
            $invoice_total = $r->extra_cost + $subtotal + $tax1;
        }else{
            $invoice_total = $r->extra_cost + $subtotal;
        }
        $balance = $invoice_total - $r->total_paid;
        $r->update(['discount' => $discount, 'subtotal'=> $subtotal, 'tax1'=>$tax1, 'tax2'=>$tax2,$r_total=>$invoice_total,'balance'=>$balance]); 
        $r->save();
    }

    public function tabsView(Request $request, $ind, $id=0)
    {
        if($id==0)
            return 0;
        $doc = $this->di('doc', $ind, $id);
        $items = Item::where('doc_ref_no',$this->di('did', $ind, $id))->get();
        if($ind==0){
            $payments = InvoicePayment::where('invoice_id',$id)->get();
        }
        $private_notes = $doc->private_notes;
        $setting = Setting::findOrFail(1);
        return view("tabs.tabs")->with(['ind'=>$ind,'items'=>$items,'payments'=>$payments??[],'private_notes'=>$private_notes,'setting'=>$setting]);
    }

    public function di($v, $ind, $id=0)
    {
        $d1 = ['invoice','order','estimate','porder'];
        $d2 = ['Invoice','Order','Estimate','Porder'];
        $d3 = ['I','R','E','P'];
        if($v=='doc'){
            \Log::Info('doc');
            return ('App\\'.$d2[$ind])::findOrFail($id);
        }
        if($v=='did'){
            return $d3[$ind].$id;
        }
        if($v=='dot'){
            return $d1[$ind].'_to';
        }
        if($v=='don'){
            return ('App\\'.$d2[$ind])::findOrFail($id)->{$d1[$ind].'_no'};
        }
        if($v=='dic'){
            return $d1[$ind];
        }
        if($v=='dtl'){
            return $d1[$ind].'_total';
        }
    }

    public function datef($a,$b=0,$c=0)
    {
        $d1 = [date('Y-m-01'),
        date('Y-01-01'),
        date('Y-01-01'),
        date('Y-m-01'),
        date('Y-m-d'),
        date('Y-m-d',strtotime('today - 30 days')),
        date('Y-m-d',strtotime('today - 60 days')),
        date('Y-m-d',strtotime('today - 90 days')),
        date('Y-m-d',strtotime('first day of last month')),
        date('Y-m-d',strtotime('last year January 1st')),
        date('Y-m-d')];
        $d2 = [date('Y-m-d'),
        date('Y-m-d'),
        date('Y-12-31'),
        date('Y-m-d',strtotime('last day of this month')),
        date('Y-m-d'),
        date('Y-m-d'),
        date('Y-m-d'),
        date('Y-m-d'),
        date('Y-m-d',strtotime('last day of last month')),
        date('Y-m-d',strtotime('last year December 31')),
        date('Y-m-d')];
        $d3 = [date('Y-01-01'),
        date('Y-01-01'),
        date('Y-m-01'),
        date('Y-m-d',strtotime('today - 3 months')),
        date('Y-m-d',strtotime('today - 6 months')),
        date('Y-m-d',strtotime('today - 12 months')),
        date('Y-m-d',strtotime('today - 18 months')),
        date('Y-m-d',strtotime('today - 24 months')),
        date('Y-m-d',strtotime('today - 30 months')),
        date('Y-m-d',strtotime('last year January 1st')),
        date('Y-m-d',strtotime(date('Y-m-d',strtotime('last year January 1st')).' - 1 years')),];
        $d4 = [date('Y-m-d'),
        date('Y-12-31'),
        date('Y-m-d',strtotime('last day of this month')),
        date('Y-m-d'),
        date('Y-m-d'),
        date('Y-m-d'),
        date('Y-m-d'),
        date('Y-m-d'),
        date('Y-m-d'),
        date('Y-m-d',strtotime('last year December 31')),
        date('Y-m-d',strtotime(date('Y-m-d',strtotime('last year December 31')).' - 1 years'))];

        if($c==0){
            if($b==0){
                return $d1[$a];
            }else{
                return $d2[$a];
            }
        }else{
            if($b==0){
                return $d3[$a];
            }else{
                return $d4[$a];
            }
        }
    }
}
