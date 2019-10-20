<?php

namespace App\Traits;

use App\Setting;
use App\Customer;
use App\Invoice;
use App\Order;
use App\Estimate;
use App\Porder;
use App\InvoicePayment;

use Illuminate\Http\Request;

trait Customers
{
	public function customerList(Request $request)
    {
        $customers = Customer::query();
        $customers = $request->query('nterm')?$customers->where('bname','LIKE','%'.$request->query('nterm').'%'):$customers;
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
        return view("customer_list")->with(["customers"=>$customers,'categories'=>$categories,'nterm'=>$request->query('nterm'),
            'category'=>$request->query('category')]);
    }

    public function addCustomerView($id = 0)
    {
        if($id!=0){
            $customer = Customer::findOrFail($id);
        }
        $categories = Customer::groupBy('category')->pluck('category');
        return view("create.customer")->with(['id'=>$id, 'c'=>$customer??'','categories'=>$categories]);
    }

    public function saveCustomer(Request $request)
    {
        \Log::Info('saveCustomer');
        $c = ['customer_id', 'category', 'status', 'bname', 'baddress', 'bcontact_person', 'bemail', 'btel', 'bfax', 'bmobile', 'sname', 'saddress', 'scontact_person', 'semail', 'stel', 'sfax', 'country', 'city', 'tax_exempt', 'discount', 'tax1_rate', 'tax2_rate', 'customer_type', 'notes',];
        $cvld = ['string|max:32', 'string|max:120', 'boolean', 'string|max:100', 'string|max:200', 'string|max:50', 'string|max:70', 'string|max:15', 'string|max:15', 'string|max:15', 'string|max:100', 'string|max:200', 'string|max:50', 'string|max:70', 'string|max:15', 'string|max:15', 'string|max:32', 'string|max:32', 'boolean', 'numeric|decimal:8,2', 'numeric|decimal:8,2', 'numeric|decimal:8,2', 'numeric|non_fraction|tinyInteger', 'string|max:65536',];
        $i=0;
        foreach ($c as $cv) {
            if(isset($request->{$cv})){
                $request->validate([$cv => $cvld[$i]]);
                if(isset($request->id)){
                    Customer::findOrFail($request->id)->update([$cv => $request->{$cv}]);
                }else{
                    $setting = Setting::findOrFail(1);
                    $id = Customer::create([$cv => $request->{$cv},'tax1_rate'=>$setting->tax1_rate,'tax2_rate'=>$setting->tax2_rate])->id;
                    return $id;
                }
                return 0;
            }
            $i++;
        }
        return 0;
    }

    public function deleteCustomers(Request $request)
    {
        foreach ($request->items as $id) {
            Customer::destroy($id);
        }
    }

    public function ctabsView(Request $request, $id=0)
    {
        $c = Customer::findOrFail($id);
        $invoices = Invoice::where('customer_id',$c->customer_id)->get();
        $orders = Order::where('customer_id',$c->customer_id)->get();
        $estimates = Estimate::where('customer_id',$c->customer_id)->get();
        $porders = Porder::where('vendor_id',$c->customer_id)->get();
        $iids = Invoice::where('customer_id',$c->customer_id)->pluck('id');
        $payments = InvoicePayment::whereIn('invoice_id',$iids)->get();
        $setting = Setting::findOrFail(1);
        return view("tabs.ctabs")->with(['invoices'=>$invoices,'orders'=>$orders,'estimates'=>$estimates,'payments'=>$payments??[],'porders'=>$porders,'setting'=>$setting]);
    }
}
