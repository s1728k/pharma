@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div id="alrt"></div>
  @if($errors->has('name'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('name')}}</div>@endif
  @if($errors->has('id'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('id')}}</div>@endif
  <div class="row menu-bar">
    <div class="col-md-10">
      <div class="btn-group btn-group-custom">
        <button class="menu_button" onclick="invoiceView()"><i class="fa fa-plus"></i><br> Generate recurring<br>Invoices</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" onclick="viewInvoice()"><i class="fa fa-pencil-square-o"></i><br> View/Edit<br>Invoice</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" onclick="printView()"><i class="fa fa-search-plus"></i><br> Print<br>Preview</button>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-print"></i><br> Print<br>Selected</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-envelope-o"></i><br> E-mail<br>Invoice</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-search"></i><br> Search In<br>Invoices</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-refresh"></i><br> Refresh<br>Invoices List</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" onclick="toggleSum()"><i class="fa fa-calculator"></i><br> Hide Totals<br>SUM</button>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top: 10px; font-size: 20px">
    <div class="col-md-6">
      <div>Recurring invoices (All)</div>
    </div>
  </div>
	<div class="row">
		<div class="col-md-12">
      <div style="border:0px solid red ;height: 250px;overflow-y: auto;border:1px solid grey; position: relative;">
  			<table class="table table-bordered table-custom">
  				<thead>
  					<tr>
  						<th style="padding: 0px"></th>
  						<th style="padding: 0px">Invoice#</th>
  						<th style="padding: 0px">Next Invoice</th>
              <th style="padding: 0px">Recurring Period</th>
              <th style="padding: 0px">Stop After</th>
              <th style="padding: 0px">Customer Name</th>
              <th style="padding: 0px">Invoice total</th>
  					</tr>
  				</thead>
  				<tbody>
            @foreach($invoices as $rec)
            <tr onclick="tabView({{$rec->id}})">
              <td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px;" id="s{{$rec->id}}" class="s"/><i class="fa fa-caret-right" id="f{{$rec->id}}"></i></td>
              <td style="padding: 0px">{{$rec->invoice_no}}</td>
              <td style="padding: 0px">{{$rec->next_invoice}}</td>
              <td style="padding: 0px">{{$rec->recurring_period}} {{$rec->recurring_unit==0?'Day(s)':'Month(s)'}}</td>
              <td style="padding: 0px">{{$rec->stop_recurring_after2}}</td>
              <td style="padding: 0px">{{$rec->invoice_to}}</td>
              <td style="padding: 0px">{{$rec->invoice_total}}</td>
            </tr>
            @endforeach
  				</tbody>
  			</table>
        <div style="position: absolute; bottom: 0px;right: 0px;">{{$invoices->appends(request()->input())->links('layouts.pagination')}}</div>
      </div>
      <div class="row" id="sum">
        <div class="col-md-12" style="font-size: 12px">
          <table class="table" style="text-align: right;">
              <tr>
                <td style="padding: 0px;width:10%;text-align: left">{{$count}} invoice(s)</td>
                <td style="padding: 0px; width:60%"></td>
                <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($it,2)}}</td>
              </tr>
          </table>
        </div>
      </div>
		</div>
	</div>
  <div class="row">
    <div class="col-md-12" id="tabs_view">
      
    </div>
  </div>
</div>

<script>
  function invoiceView(){
    $.post("{{route("invoice.recurring")}}",{"_token":"{{csrf_token()}}"},function(id, status){
      if(status=="success"){
        window.location = "{{route("invoice.new")}}/"+id;
      }
    });
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

  function viewInvoice(){
    window.location = "{{route("invoice.new")}}/" + firstID();;
  }

  var f = {"category":"{!!str_replace('&','%26',$category)!!}","fdate":"{!!str_replace('&','%26',$fdate??date('Y-m-d'))!!}","tdate":"{!!str_replace('&','%26',$tdate??date('Y-m-d'))!!}","df":"{!!str_replace('&','%26',$df)!!}"};
  var ap="";
  $(".f").on('change', function(){
    if(this.type=='checkbox'){
      f[this.name]=$('.f').eq(1).prop('checked')?1:0;
    }else{
      f[this.name]=(this.value).replace("&","%26");
    }
    for(v in f){
      ap = ap+'&'+v+"="+f[v];
    }
    ap = ap.slice(1);
    if(this.type != 'date'){
      window.location = "{{ route('invoice.index') }}?"+ap;
    }
  });

  function tabView(id){
    $.get("{{ route('tabs.view',['ind'=>0]) }}/"+id,function(data,status){
      if(status=='success'){
        $("#tabs_view").html(data);
        $(".fa-caret-right").css('visibility','hidden');
        $("#f"+id).css('visibility','visible');
      }
    })
  }
  @if($count>0)
    tabView({{$invoices[0]->id}});
  @endif

  function deleteInvoices(){
    if(!confirm('Are you sure you want to delete..?')){
      return;
    }
    var p ={'_token':'{{csrf_token()}}'}
    p['items'] = sarr();
    $.post("{{ route('invoice.delete') }}",p,function(data,status){
      if(status=='success'){
        window.location = window.location.href;
      }
    })
  }

  function printView(){
    window.location = "{{ route('print.view', ['ind'=>0]) }}/"+firstID();;
  }

  function toggleSum(){
    if($('#sum').css('visibility') == 'visible'){
      $('#sum').css('visibility','hidden');
      $("#hide").html('Show');
    }else{
      $('#sum').css('visibility','visible');
      $("#hide").html('Hide');
    }
  }
</script>
@endsection