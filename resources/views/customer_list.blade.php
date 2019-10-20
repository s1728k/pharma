@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div id="alrt"></div>
  @if($errors->has('name'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('name')}}</div>@endif
  @if($errors->has('id'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('id')}}</div>@endif
  <div class="row menu-bar">
    <div class="col-md-12">
      <div class="btn-group btn-group-custom">
        <button class="menu_button" onclick="customerView()"><i class="fa fa fa-plus"></i><br> Add New<br>Customer</button>
        <button class="menu_button" onclick="viewCustomer()"><i class="fa fa-pencil-square-o"></i><br> View/Edit<br>Customer</button>
        <button class="menu_button" onclick="deleteCustomers()"><i class="fa fa-times"></i><br> Delete<br>Selected</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-search-plus"></i><br> Preview<br>Invoices list</button>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-print"></i><br> Print<br>Invoices list</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-envelope-o"></i><br> E-mail<br>Invoices list</button>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-commenting-o"></i><br> Send SMS<br>Notification</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-cloud-upload"></i><br> Import<br>Customers</button>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-cloud-download"></i><br> Export<br>Customers</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-search"></i><br> Search In<br>Customers</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-refresh"></i><br> Refresh<br>Customers List</button>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top: 10px; font-size: 20px">
    <div class="col-md-4">
      <div>Customers (All)</div>
    </div>
    <div class="col-md-4" style="font-size:12px">
      Customer name quick search: <input type="text" style="width: 150px" name="nterm" value="{{$nterm}}" class="f">
    </div>
    <div class="col-md-4" style="font-size:12px">
      <select style="float:right; width: 150px;" name="category" class="f">
        <option @if($category == 'View all records') selected @endif>View all records</option>
        <option @if($category == 'View only Client/Vendor type') selected @endif>View only Client/Vendor type</option>
        <option @if($category == 'View only Client type') selected @endif>View only Client type</option>
        <option @if($category == 'View only Vendor type') selected @endif>View only Vendor type</option>
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
  			<table class="table table-bordered table-custom">
  				<thead>
  					<tr>
  						<th style="padding: 0px"></th>
  						<th style="padding: 0px">Customers ID</th>
  						<th style="padding: 0px">Category</th>
              <th style="padding: 0px">Customer name</th>
              <th style="padding: 0px">Contact person</th>
              <th style="padding: 0px">Customer tel</th>
              <th style="padding: 0px">SMS number</th>
              <th style="padding: 0px">Type</th>
  					</tr>
  				</thead>
  				<tbody>
            @foreach($customers as $cust)
            <tr onclick="tabView({{$cust->id}})">
              <td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px" id="s{{$cust->id}}" class="s"/><i class="fa fa-caret-right" id="f{{$cust->id}}"></i></td>
              <td style="padding: 0px">{{$cust->customer_id}}</td>
              <td style="padding: 0px">{{$cust->category}}</td>
              <td style="padding: 0px">{{$cust->bname}}</td>
              <td style="padding: 0px">{{$cust->bcontact_person}}</td>
              <td style="padding: 0px">{{$cust->btel}}</td>
              <td style="padding: 0px">{{$cust->bmobile}}</td>
              <td style="padding: 0px">{{$cust->customer_type==0?'Client':($cust->customer_type==1?'Vendor':'Client/Vendor')}}</td>
            </tr>
            @endforeach
  				</tbody>
  			</table>
      </div>
      <div style="text-align: right">{{$customers->appends(request()->input())->links('layouts.pagination')}}</div>
		</div>
    <div class="row" id="sum">
      <div class="col-md-12" style="font-size: 12px">
        <table class="table" style="text-align: right;">
            <tr>
              <td style="padding: 0px;width:10%;text-align: left">{{count($customers)}} customer(s)</td>
              <td style="padding: 0px; width:60%"></td>
              <td style="padding: 0px"></td>
              <td style="padding: 0px"></td>
              <td style="padding: 0px"></td>
            </tr>
        </table>
      </div>
    </div>
	</div>
  <div class="row">
    <div class="col-md-12" id="tabs_view">
      
    </div>
  </div>
</div>
<script>
  function customerView(){
    window.location = "{{route("customer.view")}}"
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

  function viewCustomer(){
    window.location = "{{route("customer.view")}}" + "/" + firstID()
  }

  function deleteCustomers(){
    if(!confirm('Are you sure you want to delete..?')){
      return;
    }
    var p ={'_token':'{{csrf_token()}}'}
    p['items'] = sarr();
    $.post("{{ route('customer.delete') }}",p,function(data,status){
      if(status=='success'){
        window.location = window.location.href;
      }
    })
  }

  var s = {"nterm":"{!!str_replace('&','%26',$nterm)!!}","category":"{!!str_replace('&','%26',$category)!!}"};var ap="";
  $(".f").on('change', function(){
    s[this.name]=(this.value).replace("&","%26");
    for(v in s){
      ap = ap+'&'+v+"="+s[v];
    }
    ap = ap.slice(1);
    window.location = "{{ route('customer.index') }}?"+ap;
  });

  function tabView(id){
    $.get("{{ route('ctabs.view') }}/"+id,function(data,status){
      if(status=='success'){
        $("#tabs_view").html(data);
        $(".fa-caret-right").css('visibility','hidden');
        $("#f"+id).css('visibility','visible');
      }
    })
  }
  @if(count($customers)>0)
    tabView({{$customers[0]->id}});
  @endif
</script>
@endsection