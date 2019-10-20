<table style="width: 100%"><thead><tr><th>
  	<div style="float:left;text-align: left">
  		<pre><h4 style="margin: 0px">{{$s->company_name}}</h4><br>{{$s->company_address}}<br>{{$s->sales_tax_reg_no}}</pre>
  	</div>
  	<div style="float:right;text-align: right">
  		<pre><h3 style="margin: 0px">Invoices Report</h3><br>Date From: <span style="font-weight: normal">{{date("d/m/Y", strtotime($f['fd']))}}</span> Date To: <span style="font-weight: normal">{{date("d/m/Y", strtotime($f['td']))}}</span><br>Invoice Category:<span style="font-weight: normal">{{$f['c']}}</span></pre>
  	</div>
</th></tr></thead><tbody><tr><td>
  <table class="table table-custom">
  	<thead>
  		<tr>
  			<th style="padding: 0px">No.</th>
  			<th style="padding: 0px">Date</th>
  			<th style="padding: 0px">Due date</th>
  			<th style="padding: 0px">Terms</th>
  			@if($id == 2) <th style="padding: 0px">Customer</th> @endif
  			<th style="padding: 0px">Status</th>
  			<th style="padding: 0px">Invoice Total</th>
  			@if($id == 1) <th style="padding: 0px">Total Paid</th> @endif
  			@if($id == 1) <th style="padding: 0px">Balance</th> @endif
  		</tr>
  	</thead>
  	<tbody>
  		@foreach($invoices as $i)
  		<tr>
  			<td style="padding: 0px">{{$i->invoice_no}}</td>
  			<td style="padding: 0px">{{$i->invoice_date}}</td>
  			<td style="padding: 0px">{{$i->due_date}}</td>
  			<td style="padding: 0px">{{$i->pterms}}</td>
  			@if($id == 2) <td style="padding: 0px">{{$i->invoice_to}}</td> @endif
  			<td style="padding: 0px">{{$i->status}}</td>
  			<td style="padding: 0px">{{$s->currency_sign}} {{number_format($i->invoice_total,2)}}</td>
  			@if($id == 1) <td style="padding: 0px">{{$s->currency_sign}} {{number_format($i->total_paid,2)}}</td> @endif
  			@if($id == 1) <td style="padding: 0px">{{$s->currency_sign}} {{number_format($i->balance,2)}}</td> @endif
  		</tr>
  		@endforeach
  	</tbody>
  	<tfoot>
  		<tr>
  			<th style="padding: 0px">{{count($invoices)}} Lines</th>
  			<th style="padding: 0px"></th>
  			<th style="padding: 0px"></th>
  			<th style="padding: 0px">-End of list-</th>
  			@if($id == 2) <th style="padding: 0px"></th> @endif
  			<th style="padding: 0px">Summary</th>
  			<th style="padding: 0px">Invoice Total<br>{{$s->currency_sign}} {{number_format($it,2)}}</th>
  			@if($id == 1) <th style="padding: 0px">Total Paid<br>{{$s->currency_sign}} {{number_format($tp,2)}}</th> @endif
  			@if($id == 1) <th style="padding: 0px">Balance<br>{{$s->currency_sign}} {{number_format($bl,2)}}</th> @endif
  		</tr>
  	</tfoot>
  </table>
</td></tr></tbody><tfoot><tr><td>

</td></tr></tfoot></table>