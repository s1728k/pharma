<?php

namespace App\Traits;

use App\Expense;
use App\Customer;
use App\Setting;

use Illuminate\Http\Request;

trait Expenses
{
	public function expenseList(Request $request)
    {
        $expenses = Expense::query();
        $expenses = $request->query('nterm')?$expenses->where('name','LIKE','%'.$request->query('nterm').'%'):$expenses;
        if($request->query('category') == 'View all records'){
        }elseif($request->query('category') == 'View all expenses'){
            $expenses = $expenses->where('service',0);
        }elseif($request->query('category') == 'View all services'){
            $expenses = $expenses->where('service',1);
        }else{
            $expenses = $request->query('category')?$expenses->where('category','LIKE','%'.$request->query('category').'%'):$expenses;
        }
        $expenses = $expenses->paginate(10);
        $categories = Expense::groupBy('category')->pluck('category');
        $customers = Customer::all();
        $setting = Setting::findOrFail(1);
        return view("expense_list")->with(["expenses"=>$expenses,'setting'=>$setting,'customers'=>$customers,'categories'=>$categories,'nterm'=>$request->query('nterm'),
            'category'=>$request->query('category')]);
    }

    public function addExpenseView($id = 0)
    {
        if($id!=0){
            $expense = Expense::findOrFail($id);
        }
        $categories = Expense::groupBy('category')->pluck('category');
        $customers = Customer::all();
        $setting = Setting::findOrFail(1);
        return view("create.expense")->with(['id'=>$id, 'e'=>$expense??'','setting'=>$setting,'customers'=>$customers,'categories'=>$categories]);
    }

    public function saveExpense(Request $request)
    {
        \Log::Info('saveExpense');
        $e = ['amount', 'date', 'vendor', 'category', 'description', 'staff_member', 'tax1', 'tax2', 'assign_to_customer', 'customer_name', 'rebillable', 'code', 'rebill_amount', 'attach_receipt_image', 'receipt_image', 'notes',];
        $evld = ['numeric|decimal:8,2', 'date', 'string|max:255', 'string|max:100', 'string|max:255', 'string|max:255', 'boolean', 'boolean', 'boolean', 'string|max:255', 'boolean', 'string|max:32', 'numeric|decimal:8,2', 'boolean', 'string|max:65536','string|max:65536'];
        $i=0;
        foreach ($e as $ev) {
            if(isset($request->{$ev})){
                $request->validate([$ev => $evld[$i]]);
                if(isset($request->id)){
                    Expense::findOrFail($request->id)->update([$ev => $request->{$ev}]);
                }else{
                    $id = Expense::create([$ev => $request->{$ev}])->id;
                    return $id;
                }
                return 0;
            }
            $i++;
        }
        return 0;
    }

    public function deleteExpenses(Request $request)
    {
        foreach ($request->items as $id) {
            Expense::destroy($id);
        }
    }

}
