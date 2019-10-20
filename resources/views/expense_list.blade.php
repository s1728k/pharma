@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div id="alrt"></div>
  @if($errors->has('name'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('name')}}</div>@endif
  @if($errors->has('id'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('id')}}</div>@endif
  <div class="row menu-bar">
    <div class="col-md-10">
      <div class="btn-group btn-group-custom">
        <button class="menu_button" onclick="expenseView()"><i class="fa fa-plus"></i><br> Create New<br>Expense</button>
        <button class="menu_button" onclick="viewExpense()"><i class="fa fa-pencil-square-o"></i><br> View/Edit<br>Expense</button>
        <button class="menu_button" onclick="deleteExpenses()"><i class="fa fa-times"></i><br> Delete<br>Selected</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-search"></i><br> Search In<br>Expenses</button>
        <div class="list_filter">
          <div class="row">
            <div class="col-md-4 col-xs-4">
              Expense date from:
            </div>
            <div class="col-md-4 col-xs-4">
              <input type="date" style="width: 120%">
            </div>
            <div class="col-md-4 col-xs-4">
              <input type="checkbox" /> Apply Filter
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-xs-4">
              Expense date to:
            </div>
            <div class="col-md-4 col-xs-4">
              <input type="date" style="width: 120%">
            </div>
            <div class="col-md-4 col-xs-4">
            </div>
          </div>
        </div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-refresh"></i><br> Refresh<br>Expenses List</button>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top: 10px; font-size: 20px">
    <div class="col-md-6">
      <div>Expenses (All)</div>
    </div>
    <div class="col-md-6" style="font-size:12px">
      <select style="float:right; width: 150px;">
        <option>UnCategorized</option>
      </select>
      <div style="float:right;"> Category Filter:</div>
    </div>
  </div>
	<div class="row">
		<div class="col-md-12">
  			<table class="table table-bordered table-custom">
  				<thead>
  					<tr>
  						<th style="padding: 0px"></th>
  						<th style="padding: 0px">Client</th>
  						<th style="padding: 0px">Date</th>
              <th style="padding: 0px">Category</th>
              <th style="padding: 0px">Vendor</th>
              <th style="padding: 0px">Staff member</th>
              <th style="padding: 0px">Description</th>
              <th style="padding: 0px">Rebillable</th>
              <th style="padding: 0px">Invoiced</th>
              <th style="padding: 0px">Image</th>
              <th style="padding: 0px">Rebill amount</th>
              <th style="padding: 0px">Amount</th>
  					</tr>
  				</thead>
  				<tbody>
            @foreach($expenses as $exp)
            <tr id="r{{$exp->id}}">
              <td style="text-align:center; padding: 0px"><input type="checkbox" id="s{{$exp->id}}" class="s" /></td>
              <td style="padding: 0px">{{$exp->client}}</td>
              <td style="padding: 0px">{{$exp->date}}</td>
              <td style="padding: 0px">{{$exp->category}}</td>
              <td style="padding: 0px">{{$exp->vendor}}</td>
              <td style="padding: 0px">{{$exp->staff_member}}</td>
              <td style="padding: 0px">{{$exp->description}}</td>
              <td style="padding: 0px"><input type="checkbox" @if($exp->rebillable ==1) checked @endif /></td>
              <td style="padding: 0px"><input type="checkbox" @if($exp->invoiced ==1) checked @endif /></td>
              <td style="padding: 0px">{{$exp->image}}</td>
              <td style="padding: 0px">{{$exp->rebill_amount}}</td>
              <td style="padding: 0px">{{$exp->amount}}</td>
            </tr>
            @endforeach
  				</tbody>
  			</table>
		</div>
	</div>
</div>

<script>
  function expenseView(){
    window.location = "{{route("expense.view")}}"
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

  function viewExpense(){
    window.location = "{{route("expense.view")}}" + "/" + firstID();
  }

  function deleteExpenses(){
    if(!confirm('Are you sure you want to delete..?')){
      return;
    }
    var p ={'_token':'{{csrf_token()}}'}
    p['items'] = sarr();
    $.post("{{ route('expense.delete') }}",p,function(data,status){
      if(status=='success'){
        window.location = window.location.href;
      }
    })
  }
</script>
@endsection