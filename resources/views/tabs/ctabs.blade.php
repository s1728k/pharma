<ul class="nav nav-tabs nav-custom">
  <li class="active"><a data-toggle="tab" href="#invoices">Invoices ({{count($invoices)}})</a></li>
  <li><a data-toggle="tab" href="#orders">Orders  ({{count($orders)}})</a></li>
  <li><a data-toggle="tab" href="#estimates">Estimates  ({{count($estimates)}})</a></li>
  <li><a data-toggle="tab" href="#statements">Statement ({{count($invoices)}})</a></li>
  <li><a data-toggle="tab" href="#payments">Payment  ({{count($payments)}})</a></li>
  <li><a data-toggle="tab" href="#porders">Puchase O.  ({{count($porders)}})</a></li>
</ul>

<div class="tab-content">
  <div id="invoices" class="tab-pane fade in active">
    <div style="border:0px solid red ;height: 250px;overflow-y: auto;border:1px solid grey; position: relative;">
        <table class="table table-bordered table-custom">
          <thead>
            <tr>
              <th style="padding: 0px"></th>
              <th style="padding: 0px">Invoice#</th>
              <th style="padding: 0px">Invoice date</th>
              <th style="padding: 0px">Due date</th>
              <th style="padding: 0px">Customer Name</th>
              <th style="padding: 0px">Status</th>
              <th style="padding: 0px">Emailed on</th>
              <th style="padding: 0px">Printed on</th>
              <th style="padding: 0px">SMS on</th>
              <th style="padding: 0px">Invoice total</th>
              <th style="padding: 0px">Total paid</th>
              <th style="padding: 0px">Balance</th>
            </tr>
          </thead>
          <tbody>
            @foreach($invoices as $inv)
            <tr>
              <td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px;" name="s{{$inv->id}}" class="s" /><i class="fa fa-caret-right" id="f{{$inv->id}}"></i></td>
              <td style="padding: 0px">{{$inv->invoice_no}}</td>
              <td style="padding: 0px">{{$inv->invoice_date}}</td>
              <td style="padding: 0px">{{$inv->due_date}}</td>
              <td style="padding: 0px">{{$inv->invoice_to}}</td>
              <td style="padding: 0px">{{$inv->status}}</td>
              <td style="padding: 0px">{{$inv->emailed_on}}</td>
              <td style="padding: 0px">{{$inv->printed_on}}</td>
              <td style="padding: 0px">{{$inv->sms_on}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->invoice_total,2)}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->total_paid,2)}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->balance,2)}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

          {{-- <div style="position: absolute; bottom: 0px;right: 0px;">{{$invoices->appends(request()->input())->links('layouts.pagination')}}</div> --}}
      </div>
  </div>
  <div id="estimates" class="tab-pane fade">
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

          {{-- <div style="position: absolute; bottom: 0px;right: 0px;">{{$estimates->appends(request()->input())->links('layouts.pagination')}}</div> --}}
      </div>
  </div>
  <div id="orders" class="tab-pane fade">
    <div style="border:0px solid red ;height: 250px;overflow-y: auto;border:1px solid grey; position: relative;">
        <table class="table table-bordered table-custom">
          <thead>
            <tr>
              <th style="padding: 0px"></th>
              <th style="padding: 0px">Order#</th>
              <th style="padding: 0px">Order date</th>
              <th style="padding: 0px">Due date</th>
              <th style="padding: 0px">Customer Name</th>
              <th style="padding: 0px">Status</th>
              <th style="padding: 0px">Emailed on</th>
              <th style="padding: 0px">Printed on</th>
              <th style="padding: 0px">SMS on</th>
              <th style="padding: 0px">Order total</th>
              <th style="padding: 0px">Total paid</th>
              <th style="padding: 0px">Balance</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $inv)
            <tr onclick="tabView({{$inv->id}})">
              <td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px;" id="s{{$inv->id}}" class="s" /><i class="fa fa-caret-right" id="f{{$inv->id}}"></i></td>
              <td style="padding: 0px">{{$inv->order_no}}</td>
              <td style="padding: 0px">{{$inv->order_date}}</td>
              <td style="padding: 0px">{{$inv->due_date}}</td>
              <td style="padding: 0px">{{$inv->order_to}}</td>
              <td style="padding: 0px">{{$inv->status}}</td>
              <td style="padding: 0px">{{$inv->emailed_on}}</td>
              <td style="padding: 0px">{{$inv->printed_on}}</td>
              <td style="padding: 0px">{{$inv->sms_on}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->order_total,2)}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->total_paid,2)}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->balance,2)}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

          {{-- <div style="position: absolute; bottom: 0px;right: 0px;">{{$orders->appends(request()->input())->links('layouts.pagination')}}</div> --}}
      </div>
  </div>
  <div id="statements" class="tab-pane fade">
    <div style="border:0px solid red ;height: 250px;overflow-y: auto;border:1px solid grey; position: relative;">
        <table class="table table-bordered table-custom">
          <thead>
            <tr>
              <th style="padding: 0px"></th>
              <th style="padding: 0px">Invoice#</th>
              <th style="padding: 0px">Invoice date</th>
              <th style="padding: 0px">Due date</th>
              <th style="padding: 0px">Customer Name</th>
              <th style="padding: 0px">Status</th>
              <th style="padding: 0px">Emailed on</th>
              <th style="padding: 0px">Printed on</th>
              <th style="padding: 0px">SMS on</th>
              <th style="padding: 0px">Invoice total</th>
              <th style="padding: 0px">Total paid</th>
              <th style="padding: 0px">Balance</th>
            </tr>
          </thead>
          <tbody>
            @foreach($invoices as $inv)
            <tr>
              <td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px;" name="s{{$inv->id}}" class="s" /><i class="fa fa-caret-right" id="f{{$inv->id}}"></i></td>
              <td style="padding: 0px">{{$inv->invoice_no}}</td>
              <td style="padding: 0px">{{$inv->invoice_date}}</td>
              <td style="padding: 0px">{{$inv->due_date}}</td>
              <td style="padding: 0px">{{$inv->invoice_to}}</td>
              <td style="padding: 0px">{{$inv->status}}</td>
              <td style="padding: 0px">{{$inv->emailed_on}}</td>
              <td style="padding: 0px">{{$inv->printed_on}}</td>
              <td style="padding: 0px">{{$inv->sms_on}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->invoice_total,2)}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->total_paid,2)}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->balance,2)}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

          {{-- <div style="position: absolute; bottom: 0px;right: 0px;">{{$invoices->appends(request()->input())->links('layouts.pagination')}}</div> --}}
      </div>
  </div>
  <div id="payments" class="tab-pane fade">
    <table class="table table-bordered table-custom">
      <thead>
        <tr>
          <th style="padding: 0px;">Payment Id</th>
          <th style="padding: 0px">Payment date</th>
          <th style="padding: 0px">Paid by</th>
          <th style="padding: 0px">Description</th>
          <th style="padding: 0px">Amount</th>
        </tr>
      </thead>
      <tbody>
        @foreach($payments as $p)
        <tr>
          <td style="padding: 0px">{{$p->id}}</td>
          <td style="padding: 0px">{{$p->payment_date}}</td>
          <td style="padding: 0px">{{$p->paid_by}}</td>
          <td style="padding: 0px">{{$p->description}}</td>
          <td style="padding: 0px">{{$p->amount}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div id="porders" class="tab-pane fade">
    <div style="border:0px solid red ;height: 250px;overflow-y: auto;border:1px solid grey; position: relative;">
        <table class="table table-bordered table-custom">
          <thead>
            <tr>
              <th style="padding: 0px"></th>
              <th style="padding: 0px">P. Order#</th>
              <th style="padding: 0px">P. Order date</th>
              <th style="padding: 0px">Due date</th>
              <th style="padding: 0px">Customer Name</th>
              <th style="padding: 0px">Status</th>
              <th style="padding: 0px">Emailed on</th>
              <th style="padding: 0px">Printed on</th>
              <th style="padding: 0px">SMS on</th>
              <th style="padding: 0px">P. Order total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($porders as $inv)
            <tr onclick="tabView({{$inv->id}})">
              <td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px;" id="s{{$inv->id}}" class="s" /><i class="fa fa-caret-right" id="f{{$inv->id}}"></i></td>
              <td style="padding: 0px">{{$inv->porder_no}}</td>
              <td style="padding: 0px">{{$inv->porder_date}}</td>
              <td style="padding: 0px">{{$inv->due_date}}</td>
              <td style="padding: 0px">{{$inv->porder_to}}</td>
              <td style="padding: 0px">{{$inv->status}}</td>
              <td style="padding: 0px">{{$inv->emailed_on}}</td>
              <td style="padding: 0px">{{$inv->printed_on}}</td>
              <td style="padding: 0px">{{$inv->sms_on}}</td>
              <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($inv->porder_total,2)}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

          {{-- <div style="position: absolute; bottom: 0px;right: 0px;">{{$porders->appends(request()->input())->links('layouts.pagination')}}</div> --}}
      </div>
  </div>
</div>