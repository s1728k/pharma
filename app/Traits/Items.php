<?php

namespace App\Traits;

use App\Item;
use App\Product;

use Illuminate\Http\Request;

trait Items
{
	public function addItems(Request $request)
    {
        \Log::Info('addItems');
        $doc_ref_no = $this->di('did', $request->ind, $request->id);
        foreach ($request->items as $pid) {
            $p = Product::findOrFail($pid);
            Item::create(['pid'=>$pid,'doc_ref_no'=>$doc_ref_no,'code'=>$p->code,'product'=>$p->name,'description'=>$p->description,'unit_price'=>$p->unit_price,'quantity'=>1,'weight'=>$p->weight,'tax1_rate'=>$p->tax1_rate,'tax2_rate'=>$p->tax2_rate,'price'=>$p->unit_price]);
            if($p->service == 0 && $request->ind == 0){
                $p->update(['stock'=>$p->stock-1]);
                $p->save();
            }
        }
        $this->calcSum($request->ind, $request->id);
        $items_added = Item::where('doc_ref_no',$doc_ref_no)->count();
        return $items_added;
    }

    public function saveItem(Request $request)
    {
        \Log::Info('saveItem');
        $e = explode('j',$request->param);
        $d1 = ['i1'=>'product', 'i2'=>'description', 'i3'=>'unit_price', 'i4'=>'quantity', 'i5'=>'weight', 'i6'=>'tax1_rate', 'i7'=>'tax2_rate'];
        $d2 = ['i1'=>'string|max:180', 'i2'=>'string|max:1000', 'i3'=>'numeric|decimal:8,2', 'i4'=>'numeric|non_fraction|smallIntegerUnsigned', 'i5'=>'numeric|decimal:8,2', 'i6'=>'numeric|non_fraction|tinyInteger', 'i7'=>'numeric|non_fraction|tinyInteger'];
        
        $request->validate(['param' => 'string', 'value'=>$d2[$e[0]]]);
        $i = Item::findOrFail($e[1]);

        if($e[0] == 'i4' && $request->ind == 0){
            $p = Product::findOrFail($i->pid);
            if($p->service == 0){
                $stock = $request->value - $i->quantity;
                $p->update(['stock'=>$p->stock-$stock]);
                $p->save();
            }
        }

        $i->update([$d1[$e[0]] => $request->value]);
        $i->save();
        if($e[0] == 'i3' || $e[0] == 'i4' || $e[0] == 'i6' || $e[0] == 'i7'){
            $i->update(['price'=>$i->unit_price*$i->quantity]);
            $i->save();
            $this->calcSum($request->ind, $request->id);
            return $request->id;
        }
        return 0;
    }

    public function deleteItem(Request $request)
    {
        \Log::Info('deleteItem');
        if(count($request->items)==0)
            return 0;
        foreach ($request->items as $k=>$id) {
            if($request->ind == 0){
                $i = Item::findOrFail($id);
                $p = Product::findOrFail($i->pid);
                if($p->service == 0){
                    $p->update(['stock'=>$p->stock+$i->quantity]);
                    $p->save();
                }
            }
            Item::destroy($id);
        }
        $this->calcSum($request->ind, $request->id);
        return 0;
    }

    public function moveupItem(Request $request)
    {
        \Log::Info('moveupItem');
        if(count($request->items)==0)
            return 0;
        $ids = Item::where('doc_ref_no', $request->doc_ref_no)->pluck('id')->toArray();
        foreach ($request->items as $id) {
            $i=array_search($id, $ids);
            if($i == 0)
                return 0;
            $item = Item::findOrFail($id);
            $temp = Item::findOrFail($id);
            $item2 = Item::findOrFail($ids[$i-1]);
            $item->update($item2->toArray());
            $item->save();
            $item2->update($temp->toArray());
            $item2->save();
        }
        return 1;
    }

    public function movedownItem(Request $request)
    {
        \Log::Info('movedownItem');
        if(count($request->items)==0)
            return 0;
        $ids = Item::where('doc_ref_no', $request->doc_ref_no)->pluck('id')->toArray();
        foreach (array_reverse($request->items) as $id) {
            $i=array_search($id, $ids);
            if($i == (count($ids)-1))
                return 0;
            $item = Item::findOrFail($id);
            $temp = Item::findOrFail($id);
            $item2 = Item::findOrFail($ids[$i+1]);
            $item->update($item2->toArray());
            $item->save();
            $item2->update($temp->toArray());
            $item2->save();
        }
        return 1;
    }

    public function calcSum($ind, $id)
    {
        \Log::Info('calcSum');
        \Log::Info($id);
        $items = Item::where('doc_ref_no',$this->di('did', $ind, $id))->get();
        $doc = $this->di('doc', $ind, $id);
        \Log::Info('fsdfs');
        $p = 0; $t1 = 0; $t2 = 0;
        foreach ($items as $item) {
            $p = $p + $item->price;
            if($item->tax1_rate == 1){
                $t1 = $t1 + $item->price;
            }
            if($item->tax2_rate == 1){
                $t2 = $t2 + $item->price;
            }
        }
        $doc->update(['sum' => $p, 'sumt1' => $t1, 'sumt2' => $t2]);
        $doc->save();
        $this->calcSummary($ind, $id);
    }

}
