@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div id="alrt"></div>
  @if($errors->has('name'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('name')}}</div>@endif
  @if($errors->has('id'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('id')}}</div>@endif
  <div class="row menu-bar">
    <div class="col-md-10">
      <div class="btn-group btn-group-custom">
        <button class="menu_button" onclick="submitCompanySettingForm()"><i class="fa fa-floppy-o"></i><br> Save <br>settings</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-user"></i><br> Company<br>manager</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-cubes"></i><br> Optimize<br>data tables</button>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-database"></i><br> Repair<br>databases</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-database"></i><br> Backup<br>databases</button>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-database"></i><br> Restore<br>databases</button>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top: 10px; font-size: 20px">
    <div class="col-md-6">
      <div>Settings</div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs nav-custom2">
        <li @if($id==0) class="active" @endif><a data-toggle="tab" href="#@if($id==0) home @endif" onclick="navigate(0)">Miscellaneous</a></li>
        <li @if($id==1) class="active" @endif><a data-toggle="tab" href="#@if($id==1) home @endif" onclick="navigate(1)">Company settings</a></li>
        <li @if($id==2) class="active" @endif><a data-toggle="tab" href="#@if($id==2) home @endif" onclick="navigate(2)">Invoice settings</a></li>
        <li @if($id==3) class="active" @endif><a data-toggle="tab" href="#@if($id==3) home @endif" onclick="navigate(3)">Order settings</a></li>
        <li @if($id==4) class="active" @endif><a data-toggle="tab" href="#@if($id==4) home @endif" onclick="navigate(4)">Estimate settings</a></li>
        <li @if($id==5) class="active" @endif><a data-toggle="tab" href="#@if($id==5) home @endif" onclick="navigate(5)">Administrator panel</a></li>
        <li @if($id==6) class="active" @endif><a data-toggle="tab" href="#@if($id==6) home @endif" onclick="navigate(6)">Advanced settings</a></li>
        <li @if($id==7) class="active" @endif><a data-toggle="tab" href="#@if($id==7) home @endif" onclick="navigate(7)">E-Mail templates</a></li>
        <li @if($id==8) class="active" @endif><a data-toggle="tab" href="#@if($id==8) home @endif" onclick="navigate(8)">Payments</a></li>
        <li @if($id==9) class="active" @endif><a data-toggle="tab" href="#@if($id==9) home @endif" onclick="navigate(9)">Purchase Order</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          @if($id==0)
            @include('settings.misc')
          @elseif($id==1)
            @include('settings.company')
          @elseif($id==2)
            @include('settings.invoice')
          @elseif($id==3)
            @include('settings.order')
          @elseif($id==4)
            @include('settings.estimate')
          @elseif($id==8)
            @include('settings.payments')
          @elseif($id==9)
            @include('settings.porder')
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<div id="extracost" class="modal fade" role="dialog" >
  <div class="modal-dialog" >

    <!-- Modal content-->
    <div class="modal-content" style="border-radius: 0px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Extra cost name</h4>
      </div>
      <form method="post" action="{{ route('settings.extra') }}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
      <div class="modal-body">
        <input type="text" name="name" placeholder="name goes here" style="width: 100%">
      </div>
      <div class="modal-footer">
        <button type="submit" >Save</button>
        <button type="button" data-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>

  </div>
</div>

<div id="hfootertext" class="modal fade" role="dialog" >
  <div class="modal-dialog" >

    <!-- Modal content-->
    <div class="modal-content" style="border-radius: 0px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Header/Footer text</h4>
      </div>
      <form method="post" action="{{ route('settings.hftext') }}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
      <div class="modal-body">
        <input type="text" name="hf_text" placeholder="header/footer text goes here" style="width: 100%">
      </div>
      <div class="modal-footer">
        <button type="submit" >Save</button>
        <button type="button" data-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>

  </div>
</div>

<div id="paymentterm" class="modal fade" role="dialog" >
  <div class="modal-dialog" >

    <!-- Modal content-->
    <div class="modal-content" style="border-radius: 0px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New payment term</h4>
      </div>
      <form method="post" action="{{ route('settings.pterm') }}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
      <div class="modal-body">
        <input type="text" name="pterm" placeholder="payment term name" style="width: 100%"><br><br>
        <input type="number" name="shift" placeholder="days shif" style="width: 100%">
      </div>
      <div class="modal-footer">
        <button type="submit" >Save</button>
        <button type="button" data-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>

  </div>
</div>

<script>
  function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
  }

  function navigate(id){
    window.location = "{{route("settings.index")}}/"+id
  }

  function curChange(cur){
    var d = {"INR":"₹", "USD":"$", "EUR":"€", "GBP":"£", "CAD":"$", "AUD":"$", "JPN":"¥"}
    document.getElementById("cur").innerHTML = d[cur.value];
    document.getElementById("currency_sign").value = d[cur.value];
  }

  function taxClick(t){
    if(t == 0){
      $(".t1").hide()
      $(".t2").hide()
    }
    if(t == 1){
      $(".t1").show()
      $(".t2").hide()
    }
    if(t == 2){
      $(".t1").show()
      $(".t2").show()
    }
  }

  function delExtraCost(id){
    $.post("{{ route('settings.extra.delete') }}", {"_token":"{{csrf_token()}}","id":id,"_method":"DELETE"}, function(data, status){
      if(status=="success"){
        window.location = "{{ route('settings.index',['id'=>0]) }}";
      }
    });
  }

  function delHfooterText(id){
    $.post("{{ route('settings.hftext.delete') }}", {"_token":"{{csrf_token()}}","id":id,"_method":"DELETE"}, function(data, status){
      if(status=="success"){
        window.location = "{{ route('settings.index',['id'=>0]) }}";
      }
    });
  }

  function delPaymentTerm(id){
    $.post("{{ route('settings.pterm.delete') }}", {"_token":"{{csrf_token()}}","id":id,"_method":"DELETE"}, function(data, status){
      if(status=="success"){
        window.location = "{{ route('settings.index',['id'=>0]) }}";
      }
    });
  }

  var bl = {"print_tax1":"{{$setting->print_tax1}}","print_tax2":"{{$setting->print_tax2}}","print_logo_picture":"{{$setting->print_logo_picture}}",
  "invoice_lzcy":"{{$setting->invoice_lzcy}}","order_lzcy":"{{$setting->order_lzcy}}","estimate_lzcy":"{{$setting->estimate_lzcy}}","porder_lzcy":"{{$setting->porder_lzcy}}","payments1":"{{$setting->payments1}}","payments2":"{{$setting->payments2}}","payments3":"{{$setting->payments3}}","payments4":"{{$setting->payments4}}"};
  var bll = ["print_tax1","print_tax2","print_logo_picture","invoice_lzcy","order_lzcy","estimate_lzcy","porder_lzcy","payments1","payments2","payments3","payments4"];

  $(".cs").on('change', function (){
    var p = {"_token":"{{csrf_token()}}"};
    p[this.name]=this.value;
    if(this.name == 'currency'){
      p['currency_sign']=document.getElementById("currency_sign").value;
    }
    if( bll.indexOf(this.name) != -1){
      if(bl[this.name]==1){
        bl[this.name]=0
      }else{
        bl[this.name]=1
      }
      p[this.name]=bl[this.name];
      $("[name='"+this.name+"']").prop('checked',bl[this.name])
    }
    $.post("{{ route('settings.company') }}", p, function(){});
  });

  $(".rl").on('change', function (){
    var p = {"_token":"{{csrf_token()}}"};
    p['name']=this.name;
    p['value']=this.value;
    $.post("{{ route('settings.labels') }}", p, function(){});
  });

  $(document).ready(function(){
    taxClick({{$setting->tax_type}});
  });
</script>
@endsection