@extends('layouts.app')

@section('custom_css')
{{-- <style>
  @media print {
    body * {
      visibility: hidden;
    }
    #section-to-print, #section-to-print * {
      visibility: visible;
    }
    #section-to-print {
        background-color: white;
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        margin: 0;
        padding: 15px;
        font-size: 14px;
        line-height: 18px;
    }
  }
</style> --}}
@endsection
@section('content')
<div class="container-fluid">
	<div id="alrt"></div>
  @if($errors->has('name'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('name')}}</div>@endif
  @if($errors->has('id'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('id')}}</div>@endif
  <div class="row menu-bar">
    <div class="col-md-12">
      <div class="btn-group btn-group-custom">
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-caret-square-o-right"></i><br> Run <br>Report<br>.</button>
        <button class="menu_button" onclick="printDiv('section-to-print')"><i class="fa fa-print"></i><br> Print <br>Report<br>.</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-cloud-download"></i><br> Export report<br>to Excel</button>
        <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-cloud-download"></i><br> Export report<br>to PDF</button>
        <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
        <div class="report_filter">
          <div class="row">
            <div class="col-md-3 col-xs-6">
              Report type:<br>
              <select style="width: 180px;" onchange="navigate(this)">
                <option value="0" @if($id == 0) selected @endif>Screen Charts</option>
                <option value="1" @if($id == 1) selected @endif>Invoices Report</option>
                <option value="2" @if($id == 2) selected @endif>Invoices Report (with customer)</option>
                <option value="3" @if($id == 3) selected @endif>Orders Report</option>
                <option value="4" @if($id == 4) selected @endif>Recurring invoices report</option>
                <option value="5" @if($id == 5) selected @endif>Past due invoices</option>
                <option value="6" @if($id == 6) selected @endif>Payments report</option>
                <option value="7" @if($id == 7) selected @endif>Customers list</option>
                <option value="8" @if($id == 8) selected @endif>Customers list (detailed)</option>
                <option value="9" @if($id == 9) selected @endif>Products/Services list</option>
                <option value="10" @if($id == 10) selected @endif>Price list</option>
                <option value="11" @if($id == 11) selected @endif>Products low stock report</option>
                <option value="12" @if($id == 12) selected @endif>Tax report (Invoices)</option>
                <option value="13" @if($id == 13) selected @endif>Tax report (Orders)</option>
                <option value="14" @if($id == 14) selected @endif>Sales report (group by date)</option>
                <option value="15" @if($id == 15) selected @endif>Sales summary by user name</option>
                <option value="16" @if($id == 16) selected @endif>Sales summary by Customer</option>
                <option value="17" @if($id == 17) selected @endif>Product sales with customer name</option>
                <option value="18" @if($id == 18) selected @endif>Invoices report (detailed)</option>
                <option value="19" @if($id == 19) selected @endif>Daily Invoices report (detailed)</option>
                <option value="20" @if($id == 20) selected @endif>Purchase Orders report</option>
                <option value="21" @if($id == 21) selected @endif>Expenses report</option>
              </select>
            </div>
            @if($id == 1) @include('reportsf.f1') @endif
            @if($id == 2) @include('reportsf.f1') @endif
            @if($id == 3) @include('reportsf.f1') @endif
            @if($id == 4) @include('reportsf.f1') @endif
            @if($id == 5) @include('reportsf.f1') @endif
            @if($id == 6) @include('reportsf.f1') @endif
            @if($id == 7) @include('reportsf.f1') @endif
            @if($id == 8) @include('reportsf.f1') @endif
            @if($id == 9) @include('reportsf.f1') @endif
            @if($id == 10) @include('reportsf.f1') @endif
            @if($id == 11) @include('reportsf.f1') @endif
            @if($id == 12) @include('reportsf.f1') @endif
            @if($id == 13) @include('reportsf.f1') @endif
            @if($id == 14) @include('reportsf.f1') @endif
            @if($id == 15) @include('reportsf.f1') @endif
            @if($id == 16) @include('reportsf.f1') @endif
            @if($id == 17) @include('reportsf.f1') @endif
            @if($id == 18) @include('reportsf.f1') @endif
            @if($id == 19) @include('reportsf.f1') @endif
            @if($id == 20) @include('reportsf.f1') @endif
            @if($id == 21) @include('reportsf.f1') @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top: 10px; font-size: 20px">
    <div class="col-md-6">
      <div>Reports result preview</div>
    </div>
  </div>
	<div class="row">
    <div class="col-md-12">
      <div id="section-to-print" style="border: 1px solid black; background: lavender; padding: 10px; text-align: center; height: 80vh; overflow-y:scroll ">
        <div class="row" style="background: white; border: 0px solid black; width:695px;margin:0 auto">
          <div class="col-md-12">
            @if($id == 1) @include('reports.invoice') @endif
            @if($id == 2) @include('reports.invoice') @endif
            @if($id == 3) @include('reports.invoice') @endif
            @if($id == 4) @include('reports.invoice') @endif
            @if($id == 5) @include('reports.invoice') @endif
            @if($id == 6) @include('reports.invoice') @endif
            @if($id == 7) @include('reports.invoice') @endif
            @if($id == 8) @include('reports.invoice') @endif
            @if($id == 9) @include('reports.invoice') @endif
            @if($id == 10) @include('reports.invoice') @endif
            @if($id == 11) @include('reports.invoice') @endif
            @if($id == 12) @include('reports.invoice') @endif
            @if($id == 13) @include('reports.invoice') @endif
            @if($id == 14) @include('reports.invoice') @endif
            @if($id == 15) @include('reports.invoice') @endif
            @if($id == 16) @include('reports.invoice') @endif
            @if($id == 17) @include('reports.invoice') @endif
            @if($id == 18) @include('reports.invoice') @endif
            @if($id == 19) @include('reports.invoice') @endif
            @if($id == 20) @include('reports.invoice') @endif
            @if($id == 21) @include('reports.invoice') @endif
          </div>
        </div>
      </div>
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
    window.location = "{{route("reports.index")}}/"+id.value
  }

  var f = {!! json_encode($f) !!};
  var ap="";
  $(".f").on('change', function(){
    console.log(this.type);
    if(this.type=='checkbox'){
      f[this.name]=$(this).prop('checked')?1:0;
    }else{
      f[this.name]=(this.value).replace("&","%26");
    }
    for(v in f){
      ap = ap+'&'+v+"="+f[v];
    }
    ap = ap.slice(1);
    if(this.type != 'date'){
      window.location = "{{ route('reports.index') }}/{{$id}}?"+ap;
    }
  });
</script>
@endsection