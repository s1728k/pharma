<?php
// 8496823394
// 8428915739 hcl
// 7996595018 fd
namespace App\Http\Controllers;

use App\Product;
use App\Item;
use App\Setting;
use App\Invoice;
use App\Estimate;
use App\Porder;
use App\InvoicePayment;
use App\ExtraCost;
use App\HfooterText;
use App\PaymentTerm;
use App\Customer;
use App\ReportLabel;

use App\Traits\Settings;
use App\Traits\Products;
use App\Traits\Expenses;
use App\Traits\Customers;
use App\Traits\Invoices;
use App\Traits\Orders;
use App\Traits\Estimates;
use App\Traits\Porders;
use App\Traits\Items;
use App\Traits\Common;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Settings;
    use Products;
    use Expenses;
    use Customers;
    use Invoices;
    use Orders;
    use Estimates;
    use Porders;
    use Items;
    use Common;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function expenseList()
    // {
    //      
    //     $customers = Customer::all();
    //     return view("expense_list")->with(["expenses"=>[],'setting'=>$setting,'customers'=>$customers]);
    // }

    public function reportsView(Request $request, $id = 1)
    {
        
        $cat = Invoice::groupBy('category')->pluck('category');

        $f = ['c'=>'All','fd'=>'','td'=>'','dp'=>0,'p'=>1,'v'=>1,'u'=>1];
        foreach ($f as $k => $v) {
            $f[$k] = $request->query($k)??$f[$k];
        }
        $f['fd']=$this->datef($f['dp'],$b=0,$c=0);
        $f['td']=$this->datef($f['dp'],$b=1,$c=0);

        $query = Invoice::query();
        if($f['c'] != 'All' && $f['c'] != 'null'){
            $query = $query->where('category','LIKE','%'.$f['c'].'%');
        }
        $query = $query->whereBetween('invoice_date',[$f['fd'],$f['td']]);

        $status =[];
        if($f['p']){
            $status[]='Paid';
        }
        if($f['v']){
            $status[]='Void';
        }
        if($f['u']){
            $status[]='draft';
        }
        $query = $query->whereIn('status',$status);

        $it=$query->sum('invoice_total');
        $tp=$query->sum('total_paid');
        $bl=$query->sum('balance');
        
        $s = Setting::findOrFail(1);
        return view("reports")->with(["id"=>$id,'s'=>$s,'invoices'=>$query->get(),'it'=>$it,'tp'=>$tp,'bl'=>$bl,'cat'=>$cat,'f'=>$f]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
