@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<div style="display: inline-block;padding:10px; width: 100%; border:1px solid gray; border-bottom: none">
						Select customer for {{ucfirst($dict)}}# {{$record}}
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
							<option @if($fcolumn == '0') selected @endif value="0">Customer/Vendor ID</option>
							<option @if($fcolumn == '1') selected @endif value="1">Customer/Vendor Name</option>
							<option @if($fcolumn == '2') selected @endif value="2">Phone</option>
							<option @if($fcolumn == '3') selected @endif value="3">Contact person</option>
						</select>
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
										<th style="padding: 0px">Customer/Vendor ID</th>
										<th style="padding: 0px">Customer/Vendor Name</th>
										<th style="padding: 0px">Tel.</th>
										<th style="padding: 0px">Contact person</th>
									</tr>
								</thead>
								<tbody>
									@foreach($customers as $cust)
									<tr>
										<td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px" onclick="selectP({{$cust->id}})" /></td>
										<td style="padding: 0px">{{$cust->customer_id}}</td>
										<td style="padding: 0px">{{$cust->bname}}</td>
										<td style="padding: 0px">{{$cust->btel}}</td>
										<td style="padding: 0px">{{$cust->bcontact_person}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col-md-6" style="text-align: right">{{$customers->appends(request()->input())->links('layouts.pagination')}}</div>
						</div>
					</div>
				</div>
				<div class="col-md-3" style="padding-left: 0px;">
					<div style="display: inline-block;font-size: 12px;padding:10px; width: 100%;height: 60vh; border:1px solid gray;border-left: none">
						<label>Category</label>
						<select style="width:100%;" size="19" name="category" class="f">
			        <option @if($category == 'View all records') selected @endif>View all records</option>
			        <option @if($category == 'View only Client/Vendor type') selected @endif>View only Client/Vendor type</option>
			        <option @if($category == 'View only Client type') selected @endif>View only Client type</option>
			        <option @if($category == 'View only Vendor type') selected @endif>View only Vendor type</option>
			        @foreach($categories as $cat)
			        <option @if($category == $cat) selected @endif>{{$cat}}</option>
			        @endforeach
			      </select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div style="padding:10px;border-left:1px solid grey;border:1px solid grey;border-top: none ">
						<div class="row">
							<div class="col-md-2">
									<button style="float: left" onclick="selectCutomer()">Select</button>
							</div>
							<div class="col-md-8" style="text-align: center;">
								<button onclick="viewCustomer()">Edit selected customer</button>
								<button onclick="customerView()">Add new customer</button>
							</div>
							<div class="col-md-2">
								<button style="float: right" onclick="backView()">Cancel</button>
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
    window.location = "{{ route('customer.filter',['ind'=>$ind,'id'=>$id]) }}?"+ap;
  });

  var s = [];
  function selectP(id){
    if(s.indexOf(id)!=-1){
    	s.splice(s.indexOf(id),1);
    }else{
    	s.push(id);
    }
  }

  function selectCutomer(){
  	var p = {'_token':"{{csrf_token()}}"};
  	if(s.length > 0){
  		p['customer_id'] = s[0];
  	}
  	$.post("{{ route('customer.select',['ind'=>$ind,'id'=>$id]) }}",p,function(data,status){
  		if(status == 'success'){
  			backView();
  		}
  	});
  }

  function customerView(){
    window.location = "{{route("customer.view")}}"
  }

  function viewCustomer(){
    var lid=0;var i=0;
    for(var i=0; i<s.length; i++){
      if(i==0){
        lid = s[i]
      }
      if(lid>s[i]){
        lid = s[i]
      }
    }
    window.location = "{{route("customer.view")}}" + "/" + lid
  }
</script>
@endsection