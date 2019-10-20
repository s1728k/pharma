@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row" style="margin-top: 10vh">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <ul class="nav nav-tabs nav-custom">
        <li class="active"><a data-toggle="tab" href="#home">Product/Service</a></li>
        <li><a data-toggle="tab" href="#menu1">Product Image</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <div style="border:1px solid grey; padding: 10px;display: inline-block;">
            Product/Service
            <div style="width:440px; font-size: 12px">
              <div class="row">
                <div class="col-md-3">
                  Code / SKU:
                </div>
                <div class="col-md-6">
                  <input type="text" style="width: 100%; margin-bottom: 4px" name="code" value="{{$p?$p->code:''}}" class="p">
                </div>
                <div class="col-md-3">
                  Status: <label style="font-weight: normal;"><input type="checkbox" name="status" @if($p?$p->status:0) checked @endif class="p">Active</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  Category:
                </div>
                <div class="col-md-6">
                  <div style="position:relative;width:100%;height:25px;border:0;padding:0;margin:0;">
  <select style="position:absolute;top:0px;left:0px;width:100%; height:22px;line-height:20px;margin:0;padding:0;"
          onchange="document.getElementById('displayValue').value=this.options[this.selectedIndex].text; document.getElementById('idValue').value=this.options[this.selectedIndex].value;" name="category" class="p">
    <option></option>
    @foreach($categories as $category)
    <option>{{$category}}</option>
    @endforeach
  </select>
  <input type="text" id="displayValue" 
         placeholder="add/select a value" onfocus="this.select()"
         style="position:absolute;top:0px;left:0px;width:185px;height:22px;border:1px solid #aaa;" name="category" value="{{$p?$p->category:''}}" class="p" >
  <input name="idValue" id="idValue" type="hidden">
</div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  Name:
                </div>
                <div class="col-md-9">
                  <input type="text" style="width: 100%; margin-bottom: 4px" name="name" value="{{$p?$p->name:''}}" class="p" >
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  Description:
                </div>
                <div class="col-md-9">
                  <input type="text" style="width: 100%; margin-bottom: 4px" name="description" value="{{$p?$p->description:''}}" class="p" >
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  Unit price:
                </div>
                <div class="col-md-3">
                  <input type="text" style="width: 100%; margin-bottom: 4px" name="unit_price" value="{{$p?$p->unit_price:''}}" class="p" >
                </div>
                <div class="col-md-3">
                  Pcs/Weight:
                </div>
                <div class="col-md-3">
                  <input type="text" style="width: 100%; margin-bottom: 4px" name="weight" value="{{$p?$p->weight:''}}" class="p" >
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  Cost:
                </div>
                <div class="col-md-3">
                  <input type="text" style="width: 100%; margin-bottom: 4px" name="cost" value="{{$p?$p->cost:''}}" class="p" >
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                  <label style="font-weight: normal;"><input type="checkbox" name="tax1_rate" @if($p?$p->tax1_rate:0) checked @endif class="p">Taxable TAX1 rate</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  (Price - Cost):
                </div>
                <div class="col-md-3">
                  <input type="text" style="width: 100%; margin-bottom: 4px" id="profit" value="{{$profit??''}}">
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                  <label style="font-weight: normal;"><input type="checkbox" name="tax2_rate" @if($p?$p->tax2_rate:0) checked @endif class="p">Taxable TAX2 rate</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-8"><label style="font-weight: normal;"><input type="checkbox" name="service" class="p">This is a service (no stock control)</label></div>
              </div>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-1">Stock:</div>
                <div class="col-md-3" style="text-align: left;"><input type="text" style="width: 100%; margin-bottom: 4px" name="stock" value="{{$p?$p->stock:''}}" class="p" ></div>
                <div class="col-md-4" style="padding:0px;text-align: center">Low stock warning limit:</div>
                <div class="col-md-2" style="padding:0px;text-align: left"><input type="text" style="width: 100%; margin-bottom: 4px" name="low_stock_warning_limit" value="{{$p?$p->low_stock_warning_limit:''}}" class="p" ></div>
              </div>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-2">Warehouse:</div>
                <div class="col-md-8" style="padding-right:0px;"><input type="text" style="width: 100%; margin-bottom: 4px" name="warehouse" value="{{$p?$p->warehouse:''}}" class="p" ></div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  Private notes (not appears on invoice):
                  <textarea rows="4" style="width: 100%" name="notes" class="p" >{{$p?$p->notes:''}}</textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button>Save</button><button style="float:right" onclick="cancel()">Back</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="menu1" class="tab-pane fade">
          <div style="border:1px solid grey; padding: 10px;display: inline-block; font-size: 13px">
            Upload for product image file (recommended image type: JPG, size 480x320 pixels)
            <image src="https://via.placeholder.com/480x320">
            <label style="font-weight: normal;"><input type="checkbox">Automatically attach product image to invoice documents</label>
          </image>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function cancel(){
    window.location="{{route("product.index")}}"
  }

  var id = {{$id}};

  $(".p").on('change', function(){
    var p = {"_token":"{{csrf_token()}}"};
    if(id!=0){
      p['id']=id
    }

    if(this.type=='checkbox'){
      p[this.name]=$("[name='"+this.name+"']").prop('checked')?1:0;
    }else{
      p[this.name]=this.value;
    }

    $.post("{{ route('product.save') }}",p,function(id,status){
      if(status=='success'){
        if(id!=0){
          window.location="{{route("product.view")}}/"+id;
        }
      }
    });
  });
  
</script>
@endsection