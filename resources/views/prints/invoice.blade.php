@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<button style="float: right" onclick="history.back();">Close</button><button style="float: right" onclick="printDiv('section-to-print')">Print</button>
		</div>
	</div>
	<div class="row">
    <div class="col-md-12">
      <div id="section-to-print" style="border: 1px solid black; background: lavender; padding: 10px; text-align: center; height: 90vh; overflow-y:scroll ">
        <div style="background: white; border: 0px solid black; width:695px; margin:0 auto; position: relative;">
          <div style="text-align: center;padding-right: 10px;padding-left: 10px;">
          	<table style="width: 100%"><thead><tr><td>
	            <div class="row">
	            	<div class="col-md-12">
						      <p style="text-align: center;">{{$d->title_text??''}}</p>
						      <image src="https://via.placeholder.com/150x100" style="float: left">
						      <div style="float: right; text-align: right">
						        <pre><h3>{{$s->company_name}}</h3>{{$s->company_address}}<br>GSTIN:{{$s->sales_tax_reg_no}}</pre>
						      </div>
						    </div>
	            </div>
            </td></tr></thead><tbody><tr><td>
            	<div class="row">
	            	<div class="col-md-12">
						      <div style="float: left">
						        <div class="row">
						          <div class="col-md-12">
						          	<pre><table>
						          				<tr>
						          					<td style="width: 100px;text-align: left;">{{$l[1]}}</td>
						          					<td style="width: 100px;text-align: left;">{{$d->invoice_no}}</td>
						          				</tr>
						          				<tr>
						          					<td style="width: 100px;text-align: left;">{{$l[2]}}</td>
						          					<td style="width: 100px;text-align: left;">{{$d->invoice_date}}</td>
						          				</tr>
						          				<tr>
						          					<td style="width: 100px;text-align: left;">{{$l[3]}}</td>
						          					<td style="width: 100px;text-align: left;">{{$d->due_date}}</td>
						          				</tr>
						          				<tr>
						          					<td style="width: 100px;text-align: left;">{{$l[5]}}</td>
						          					<td style="width: 100px;text-align: left;">{{$d->pterms}}</td>
						          				</tr>
						          				<tr>
						          					<td style="width: 100px;text-align: left;">{{$l[4]}}</td>
						          					<td style="width: 100px;text-align: left;">{{$d->order_ref_no}}</td>
						          				</tr>
						          		</table></pre>
						          </div>
						        </div>
						      </div>
						      <div style="float: right;text-align: right">
						      	<pre><h3>{{$l[0]}}</h3></pre>
						      </div>
						    </div>
	            </div>
	            <div class="row">
				        <div class="col-md-12">
				        	<div style="float: left;margin-left: 100px;">
				          <pre><u>{{$l[6]}}</u><br>{{$d->invoice_to}}<br>{{$d->iaddress}}</pre></div>
				          <div style="float: right;margin-right: 100px;">
				          <pre><u>{{$l[7]}}</u><br>{{$d->ship_to}}<br>{{$d->saddress}}</pre></div>
				        </div>
	            </div>
	            <div class="row">
	            	<div class="col-md-12">
						      <table class="table table-bordered" style="font-family: monospace;font-size: 12px;">
						        <thead>
						          <tr>
						            <th style="padding: 0px">{{$l[8]}}</th>
						            <th style="padding: 0px">{{$l[9]}} - {{$l[11]}}</th>
						            <th style="padding: 0px">{{$l[10]}}</th>
						            <th style="padding: 0px;width: 100px">{{$l[12]}}</th>
						            <th style="padding: 0px;width: 100px">{{$l[13]}}</th>
						          </tr>
						        </thead>
						        <tbody>
						        	@foreach($items as $item)
						          <tr>
						            <td style="padding: 0px">{{$item->code}}</td>
						            <td style="padding: 0px">{{$item->product}} - {{$item->description}}</td>
						            <td style="padding: 0px">{{$item->quantity}}</td>
						            <td style="padding: 0px">{{$s->currency_sign}} {{number_format($item->unit_price,2)}}</td>
						            <td style="padding: 0px">{{$s->currency_sign}} {{number_format($item->price,2)}}</td>
						          </tr>
						          @endforeach
						          <tr>
						            <td colspan="2" style="visibility: hidden;"></td>
						            <td colspan="2" style="padding: 0px">{{$d->discount_rate}}% {{$l[15]}}</td>
						            <td style="padding: 0px">{{$s->currency_sign}} {{number_format($d->discount,2)}}</td>
						          </tr>
						          <tr>
						            <td colspan="2" style="visibility: hidden;"></td>
						            <td colspan="2" style="padding: 0px">{{$l[14]}}</td>
						            <td style="padding: 0px">{{$s->currency_sign}} {{number_format($d->subtotal,2)}}</td>
						          </tr>
						          @if($s->tax_type != 0)
						          <tr>
						            <td colspan="2" style="visibility: hidden;"></td>
						            <td colspan="2" style="padding: 0px">{{$l[17]}}</td>
						            <td style="padding: 0px">{{$s->currency_sign}} {{number_format($d->tax1,2)}}</td>
						          </tr>
						          @endif
						          @if($s->tax_type == 2)
						          <tr>
						            <td colspan="2" style="visibility: hidden;"></td>
						            <td colspan="2" style="padding: 0px">{{$l[18]}}</td>
						            <td style="padding: 0px">{{$s->currency_sign}} {{number_format($d->tax2,2)}}</td>
						          </tr>
						          @endif
						          <tr>
						            <td colspan="2" style="visibility: hidden;"></td>
						            <td colspan="2" style="padding: 0px">{{$d->extra_cost_name??'Extra cost'}}</td>
						            <td style="padding: 0px">{{$s->currency_sign}} {{number_format($d->extra_cost,2)}}</td>
						          </tr>
						          <tr>
						            <td colspan="2" style="visibility: hidden;"></td>
						            <td colspan="2" style="padding: 0px">{{$l[19]}}</td>
						            <td style="padding: 0px">{{$s->currency_sign}} {{number_format($d->invoice_total,2)}}</td>
						          </tr>
						          <tr>
						            <td colspan="2" style="visibility: hidden;"></td>
						            <td colspan="2" style="padding: 0px">{{$l[20]}}</td>
						            <td style="padding: 0px">{{$s->currency_sign}} {{number_format($d->total_paid,2)}}</td>
						          </tr>
						          <tr>
						            <td colspan="2" style="visibility: hidden;"></td>
						            <td colspan="2" style="padding: 0px">{{$l[21]}}</td>
						            <td style="padding: 0px">{{$s->currency_sign}} {{number_format($d->balance,2)}}</td>
						          </tr>
						        </tbody>
						      </table>
						    </div>
	            </div>
            </td></tr></tbody><tfoot><tr><td><div class="footer-space">&nbsp;</div>
	            <div class="row">
	            	<div class="col-md-12" style="font-family: monospace;font-size: 12px">
						      <p style="text-align: center; border-bottom: 1px solid black;">{{$l[22]}}</p>
						      <p>{{$d->terms}}</p>
						    </div>
	            </div>
            </td></tr></tfoot></table><div class="header">&nbsp;</div><div class="footer">&nbsp;</div>
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

</script>
@endsection