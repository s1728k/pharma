@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div id="alrt"></div>
  @if($errors->has('name'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('name')}}</div>@endif
  @if($errors->has('id'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('id')}}</div>@endif
  <div class="row menu-bar">
    <div class="col-md-10">
      <div class="btn-group btn-group-custom">
        <button class="menu_button" onclick="estimateView()"><i class="fa fa-plus"></i><br> Create New<br>Estimate</button>
        <button class="menu_button" onclick="viewEstimate()"><i class="fa fa-pencil-square-o"></i><br> View/Edit<br>Estimate</button>
        <button class="menu_button" onclick="deleteEstimates()"><i class="fa fa-times"></i><br> Delete<br>Selected</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" onclick="convertToInvoice()"><i class="fa fa-file-text-o"></i><br> Convert to<br>Invoice</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" onclick="printView()"><i class="fa fa-search-plus"></i><br> Print<br>Preview</button>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-print"></i><br> Print<br>Selected</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-envelope-o"></i><br> E-mail<br>Estimate</button>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-commenting-o"></i><br> Send SMS<br>Notification</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-search"></i><br> Search In<br>Estimates</button>
        <div class="list_filter">
          <div class="row">
            <div class="col-md-4 col-xs-4">
              Estimate date from:
            </div>
            <div class="col-md-4 col-xs-4">
              <input type="date" style="width: 120%" name='fdate' value="{{$fdate??date('Y-m-d')}}" class="f">
            </div>
            <div class="col-md-4 col-xs-4">
              <label><input type="checkbox" name='df' @if($df) checked @endif class="f" /> Apply Filter</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-xs-4">
              Estimate date to:
            </div>
            <div class="col-md-4 col-xs-4">
              <input type="date" style="width: 120%" name='tdate' value="{{$tdate??date('Y-m-d')}}" class="f">
            </div>
            <div class="col-md-4 col-xs-4">
            </div>
          </div>
        </div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-refresh"></i><br> Refresh<br>Estimates List</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" onclick="toggleSum()"><i class="fa fa-calculator"></i><br> <span id="hide">Hide</span> Totals<br>SUM</button>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top: 10px; font-size: 20px">
    <div class="col-md-6">
      <div>Estimates (All)</div>
    </div>
    <div class="col-md-6" style="font-size:12px">
      <select style="float:right; width: 150px;" name="category" id="category" class="f">
        <option>UnCategorized</option>
        @foreach($categories as $cat)
        <option @if($category == $cat) selected @endif>{{$cat}}</option>
        @endforeach
      </select>
      <div style="float:right;"> Category Filter:</div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div style="border:0px solid red ;height: 250px;overflow-y: auto;border:1px solid grey; position: relative;">
        <table class="table table-bordered table-custom">
          <thead>
            <tr>
              <th style="padding: 0px"></th>
              <th style="padding: 0px">Estimate#</th>
              <th style="padding: 0px">Estimate date</th>
              <th style="padding: 0px">Due date</th>
              <th style="padding: 0px">Customer Name</th>
              <th style="padding: 0px">Status</th>
              <th style="padding: 0px">Emailed on</th>
              <th style="padding: 0px">Printed on</th>
              <th style="padding: 0px">SMS on</th>
              <th style="padding: 0px">Estimate total</th>
              <th style="padding: 0px">Total paid</th>
              <th style="padding: 0px">Balance</th>
            </tr>
          </thead>
          <tbody>
            @foreach($estimates as $inv)
            <tr onclick="tabView({{$inv->id}})">
              <td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px;" id="s{{$inv->id}}" class="s" /><i class="fa fa-caret-right" id="f{{$inv->id}}"></i></td>
              <td style="padding: 0px">{{$inv->estimate_no}}</td>
              <td style="padding: 0px">{{$inv->estimate_date}}</td>
              <td style="padding: 0px">{{$inv->due_date}}</td>
              <td style="padding: 0px">{{$inv->estimate_to}}</td>
              <td style="padding: 0px">{{$inv->status}}</td>
              <td style="padding: 0px">{{$inv->emailed_on}}</td>
              <td style="padding: 0px">{{$inv->printed_on}}</td>
              <td style="padding: 0px">{{$inv->sms_on}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->estimate_total,2)}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->total_paid,2)}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->balance,2)}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

          <div style="position: absolute; bottom: 0px;right: 0px;">{{$estimates->appends(request()->input())->links('layouts.pagination')}}</div>
      </div>
      <div class="row" id="sum">
        <div class="col-md-12" style="font-size: 12px">
          <table class="table" style="text-align: right;">
              <tr>
                <td style="padding: 0px;width:10%;text-align: left">{{$count}} estimate(s)</td>
                <td style="padding: 0px; width:60%"></td>
                <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($it,2)}}</td>
                <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($tp,2)}}</td>
                <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($bl,2)}}</td>
              </tr>
          </table>
        </div>
      </div>
      
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" id="tabs_view">
      {{-- @include('tabs.tabs') --}}
    </div>
  </div>
</div>

<script>
  function estimateView(){
    $.post("{{route("estimate.new")}}",{"_token":"{{csrf_token()}}"},function(id, status){
      if(status=="success"){
        window.location = "{{route("estimate.new")}}/"+id;
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

  function viewEstimate(){
    window.location = "{{route("estimate.new")}}/" + firstID();
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
      window.location = "{{ route('estimate.index') }}?"+ap;
    }
  });

  function tabView(id){
    $.get("{{ route('tabs.view',['ind'=>2]) }}/"+id,function(data,status){
      if(status=='success'){
        $("#tabs_view").html(data);
        $(".fa-caret-right").css('visibility','hidden');
        $("#f"+id).css('visibility','visible');
      }
    })
  }
  @if($count>0)
    tabView({{$estimates[0]->id}});
  @endif

  function deleteEstimates(){
    if(!confirm('Are you sure you want to delete..?')){
      return;
    }
    var p ={'_token':'{{csrf_token()}}'}
    p['items'] = sarr();
    $.post("{{ route('estimate.delete') }}",p,function(data,status){
      if(status=='success'){
        window.location = window.location.href;
      }
    })
  }

  function printView(){
    window.location = "{{ route('print.view', ['ind'=>2]) }}/"+firstID();;
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

  function convertToInvoice(){
    var p = {'_token':'{{csrf_token()}}'};
    p['id'] = firstID();;
    $.post('{{ route('estimate.invoice') }}',p,function(iid,status){
      if(status=='success'){
        window.location = "{{route("invoice.new")}}/"+iid;
      }
    })
  }
</script>
@endsection