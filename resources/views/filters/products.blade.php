@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<div style="display: inline-block;padding:10px; width: 100%; border:1px solid gray; border-bottom: none">
						Select items for {{ucfirst($dict)}}# {{$record}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div style="display: inline-block;font-size: 12px;padding:10px; width: 100%; border:1px solid gray; border-bottom: none">
						<label>Enter filter text</label>
						<input type="text" style="width:150px" name="cterm" value="{{$cterm}}" class="f" />
						<label>Filtered Column</label>
						<select type="text" style="width:150px" name="fcolumn" class="f">
							<option @if($fcolumn == '0') selected @endif value="0">Product/Service ID</option>
							<option @if($fcolumn == '1') selected @endif value="1">Product/Service Name</option>
							<option @if($fcolumn == '2') selected @endif value="2">Price</option>
						</select>
						<label style="float: right"><input type="checkbox">Show products out of stock</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9" style="padding-right: 0px;">
					<div style="display: inline-block;font-size: 12px;padding:10px; width: 100%;height: 60vh; border:1px solid gray">
						<div style="border:0px solid red ;height: 210px;overflow-y: auto;">
							<table class="table table-bordered table-custom">
								<thead>
									<tr>
										<th style="padding: 0px"></th>
										<th style="padding: 0px">ID/SKU</th>
										<th style="padding: 0px">Product/Service Name</th>
										<th style="padding: 0px">Unit Price</th>
										<th style="padding: 0px">Service</th>
										<th style="padding: 0px">Stock</th>
									</tr>
								</thead>
								<tbody>
									@foreach($products as $prod)
			            @php
			              if($prod->service == 1){$color = 'blue';}elseif($prod->stock>$prod->low_stock_warning_limit){$color = 'green';}else{$color = 'red';}
			            @endphp
									<tr style="color:{{$color}}">
										<td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px" onclick="selectP({{$prod->id}})" /></td>
										<td style="padding: 0px">{{$prod->code}}</td>
										<td style="padding: 0px">{{$prod->name}}</td>
										<td style="padding: 0px">{{$prod->unit_price}}</td>
										<td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px" @if($prod->service == 1) checked @endif /></td>
										<td style="padding: 0px">{{$prod->stock}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col-md-6" style="text-align: left" id="n">{{$items_added}} item{{$items_added>1?'s':''}} in {{$dict}}.</div>
							<div class="col-md-6" style="text-align: right">{{$products->appends(request()->input())->links('layouts.pagination')}}</div>
						</div>
					</div>
				</div>
				<div class="col-md-3" style="padding-left: 0px;">
					<div style="display: inline-block;font-size: 12px;padding:10px; width: 100%;height: 60vh; border:1px solid gray;border-left: none">
						<label>Category</label>
						<select type="text" style="width:100%;" size="20" name="category" class="f">
							<option @if($category == 'View all records') selected @endif>View all records</option>
			        <option @if($category == 'View all products') selected @endif>View all products</option>
			        <option @if($category == 'View all services') selected @endif>View all services</option>
			        @foreach($categories as $cat)
			        <option @if($category == $cat) selected @endif>{{$cat}}</option>
			        @endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" >
					<div style="padding:10px;border-left:1px solid grey;border:1px solid grey;border-bottom: none; ">
						<span style="color:green">Green: Stock is OK</span>|---|
						<span style="color:red">Red: Stock <= Low Stock Limit</span>|---|
						<span style="color:blue">Blue: Service, no stock control</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div style="padding:10px;border-left:1px solid grey;border:1px solid grey;border-top: none ">
						<div class="row">
							<div class="col-md-2">
									<button style="float: left" onclick="addItems()">Add item/s</button>
							</div>
							<div class="col-md-8" style="text-align: center;">
								<button onclick="viewProduct()">Edit selected Product/Service</button>
								<button onclick="productView()">Add new Product/Service</button>
							</div>
							<div class="col-md-2">
								<button style="float: right" onclick="backView()">Back</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var ind = {{$ind}}; var id = {{$id}};
	function backView(){
		if(ind == 0){
      window.location = "{{route("invoice.new")}}/"+id;
		}else if(ind == 1){
			window.location = "{{route("order.new")}}/"+id;
		}else if(ind == 2){
			window.location = "{{route("estimate.new")}}/"+id;
		}else if(ind == 3){
			window.location = "{{route("porder.new")}}/"+id;
		}
  }

  var f = {"cterm":"{!!str_replace('&','%26',$cterm)!!}","fcolumn":"{!!str_replace('&','%26',$fcolumn)!!}","category":"{!!str_replace('&','%26',$category)!!}"};
  var ap="";
  $(".f").on('change', function(){
    f[this.name]=(this.value).replace("&","%26");
    for(v in f){
      ap = ap+'&'+v+"="+f[v];
    }
    ap = ap.slice(1);
    window.location = "{{ route('product.filter',['ind'=>$ind,'id'=>$id]) }}?"+ap;
  });

  var s = [];
  function selectP(id){
    if(s.indexOf(id)!=-1){
    	s.splice(s.indexOf(id),1);
    }else{
    	s.push(id);
    }
  }

  function addItems(){
  	var p = {'_token':"{{csrf_token()}}"};
  	p['items'] = s;
  	p['ind'] = {{$ind}};
  	p['id'] = {{$id}};
  	$.post("{{ route('item.add') }}",p,function(items,status){
  		if(status == 'success'){
  			window.location = window.location.href;
  		}
  	});
  }

  function productView(){
    window.location = "{{route("product.view")}}"
  }

  function viewProduct(){
    var lid=0;var i=0;
    for(var i=0; i<s.length; i++){
      if(i==0){
        lid = s[i]
      }
      if(lid>s[i]){
        lid = s[i]
      }
    }
    window.location = "{{route("product.view")}}" + "/" + lid
  }
</script>
@endsection