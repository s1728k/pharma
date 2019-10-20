<?php

namespace App\Traits;

use App\Product;

use Illuminate\Http\Request;

trait Products
{
	public function productList(Request $request)
    {
        $products = Product::query();
        $products = $request->query('nterm')?$products->where('name','LIKE','%'.$request->query('nterm').'%'):$products;
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
        return view("product_list")->with(["products"=>$products,'categories'=>$categories,'nterm'=>$request->query('nterm'),
            'category'=>$request->query('category')]);
    }

    public function addProductView($id = 0)
    {
        if($id!=0){
            $product = Product::findOrFail($id);
            $profit = $product->unit_price - $product->cost;
        }
        $categories = Product::groupBy('category')->pluck('category');
        return view("create.product")->with(['id'=>$id, 'p'=>$product??'','categories'=>$categories, 'profit'=>$profit??'']);
    }

    public function saveProduct(Request $request)
    {
        \Log::Info('saveProduct');
        $p = ['code', 'category', 'status', 'name', 'description', 'unit_price', 'cost', 'weight', 'tax1_rate', 
        'tax2_rate', 'service', 'stock', 'low_stock_warning_limit', 'warehouse', 'notes',];
        $pvld = ['string|max:32', 'string|max:120', 'boolean', 'string|max:180', 'string|max:1000', 
        'numeric|decimal:8,2', 'numeric|decimal:8,2', 'numeric|decimal:8,2', 'numeric|non_fraction|tinyInteger', 'numeric|non_fraction|tinyInteger', 'boolean', 
        'numeric|non_fraction|integer_custom_unsigned', 'numeric|non_fraction|integer_custom_unsigned', 'string|max:120', 'string|max:65536',];
        $i=0;
        foreach ($p as $pv) {
            if(isset($request->{$pv})){
                $request->validate([$pv => $pvld[$i]]);
                if(isset($request->id)){
                    Product::findOrFail($request->id)->update([$pv => $request->{$pv}]);
                }else{
                    $id = Product::create([$pv => $request->{$pv}])->id;
                    return $id;
                }
                return 0;
            }
            $i++;
        }
        return 0;
    }

    public function deleteProducts(Request $request)
    {
        foreach ($request->items as $id) {
            Product::destroy($id);
        }
    }
}
