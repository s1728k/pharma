@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div id="alrt"></div>
  @if($errors->has('name'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('name')}}</div>@endif
  @if($errors->has('id'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('id')}}</div>@endif
  <div class="row menu-bar">
    <div class="col-md-10">
      <div class="btn-group btn-group-custom">
        <button class="menu_button" onclick="productView()"><i class="fa fa-plus"></i><br> Add New<br>Product</button>
        <button class="menu_button" onclick="viewProduct()"><i class="fa fa-pencil-square-o"></i><br> View/Edit<br>Product</button>
        <button class="menu_button" onclick="deleteProducts()"><i class="fa fa-times"></i><br> Delete<br>Selected</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-cloud-upload"></i><br> Import<br>Products</button>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-cloud-download"></i><br> Export<br>Products</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-search"></i><br> Search In<br>Products</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-refresh"></i><br> Refresh<br>Products List</button>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top: 10px; font-size: 20px">
    <div class="col-md-4">
      <div>Products/Services (All)</div>
    </div>
    <div class="col-md-4" style="font-size:12px">
      Product name quick search: <input type="text" style="width: 150px" name="nterm" value="{{$nterm}}" class="f">
    </div>
    <div class="col-md-4" style="font-size:12px">
      <select style="float:right; width: 150px;" name="category" class="f">
        <option @if($category == 'View all records') selected @endif>View all records</option>
        <option @if($category == 'View all products') selected @endif>View all products</option>
        <option @if($category == 'View all services') selected @endif>View all services</option>
        @foreach($categories as $cat)
        <option @if($category == $cat) selected @endif>{{$cat}}</option>
        @endforeach
      </select>
      <div style="float:right;"> Category Filter:</div>
    </div>
  </div>
	<div class="row">
		<div class="col-md-12">
      <div style="border:0px solid red ;height: 210px;">
  			<table class="table table-bordered table-custom" style="margin-bottom: 10px;">
  				<thead>
  					<tr>
  						<th style="padding: 0px"></th>
  						<th style="padding: 0px">Product/Service ID</th>
  						<th style="padding: 0px">Category</th>
              <th style="padding: 0px">Active</th>
              <th style="padding: 0px">Name</th>
              <th style="padding: 0px">Price</th>
              <th style="padding: 0px">Stock</th>
              <th style="padding: 0px">Location/Warehouse</th>
              <th style="padding: 0px">Image</th>
  					</tr>
  				</thead>
  				<tbody>
            @foreach($products as $prod)
            @php
              if($prod->service == 1){$color = 'blue';}elseif($prod->stock>$prod->low_stock_warning_limit){$color = 'green';}else{$color = 'red';}
            @endphp
            <tr id="r{{$prod->id}}" style="color:{{$color}}">
              <td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px" id="s{{$prod->id}}" class="s" /></td>
              <td style="padding: 0px">{{$prod->code}}</td>
              <td style="padding: 0px">{{$prod->category}}</td>
              <td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px" @if($prod->status == 1) checked @endif /></td>
              <td style="padding: 0px">{{$prod->name}}</td>
              <td style="padding: 0px">{{$prod->unit_price}}</td>
              <td style="padding: 0px">{{$prod->stock}}</td>
              <td style="padding: 0px">{{$prod->warehouse}}</td>
              <td style="padding: 0px"><a href="{{$prod->image}}">view</a></td>
            </tr>
            @endforeach
  				</tbody>
  			</table>
      </div>
      <div style="text-align: right">{{$products->appends(request()->input())->links('layouts.pagination')}}</div>
      <hr style="border:1px solid lightgrey; margin-top: 0px; ">
		</div>
	</div>
  <div class="row">
    <div class="col-md-12">
      <span style="color:green">Green: Stock is OK</span><br>
      <span style="color:red">Red: Stock <= Low stock limit</span><br>
      <span style="color:blue">Blue: Service, no stock control</span>
    </div>
  </div>
</div>
<script>
  function productView(){
    window.location = "{{route("product.view")}}"
  }

  function sarr(){
    var s = [];
    $('.s').each(function(i){
      if($(this).prop('checked')){
        s.push(this.id.replace('s',''));
      }
    })
    return s;
  }

  function firstID(){
    var s = sarr();
    return s[0];
  }

  function viewProduct(){
    window.location = "{{route("product.view")}}" + "/" + firstID();
  }

  function deleteProducts(){
    if(!confirm('Are you sure you want to delete..?')){
      return;
    }
    var p ={'_token':'{{csrf_token()}}'}
    p['items'] = sarr();
    $.post("{{ route('product.delete') }}",p,function(data,status){
      if(status=='success'){
        window.location = window.location.href;
      }
    })
  }

  var f = {"nterm":"{!!str_replace('&','%26',$nterm)!!}","category":"{!!str_replace('&','%26',$category)!!}"};var ap="";
  $(".f").on('change', function(){
    f[this.name]=(this.value).replace("&","%26");
    for(v in f){
      ap = ap+'&'+v+"="+f[v];
    }
    ap = ap.slice(1);
    window.location = "{{ route('product.index') }}?"+ap;
  });
</script>
@endsection