<div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block">
  Extra cost list <button style="float: right" data-toggle="modal" data-target="#extracost">Add new line</button>
  <div style="width:400px; height: 200px; overflow-y: scroll; background: white">
    <table class="table table-bordered table-custom">
      <thead>
        <tr>
          <th style="padding: 0px">Extra cost name</th>
          <th style="padding: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($extras as $extra)
        <tr>
          <td style="padding: 0px">{{$extra->name}}</td>
          <td style="padding: 0px"><a href="javscript::void()" onclick="delExtraCost({{$extra->id}})">delete</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block">
  Predefined text records for header and footer <button style="float: right" data-toggle="modal" data-target="#hfootertext">Add new line</button>
  <div style="width:400px; height: 200px; overflow-y: scroll; background: white">
    <table class="table table-bordered table-custom">
      <thead>
        <tr>
          <th style="padding: 0px">Header/Footer text</th>
          <th style="padding: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($hfooters as $hfooter)
        <tr>
          <td style="padding: 0px">{{$hfooter->hf_text}}</td>
          <td style="padding: 0px"><a href="javscript::void()" onclick="delHfooterText({{$hfooter->id}})">delete</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block">
  Terms of payment <button style="float: right" data-toggle="modal" data-target="#paymentterm">Add new line</button>
  <div style="width:400px; height: 200px; overflow-y: scroll; background: white">
    <table class="table table-bordered table-custom">
      <thead>
        <tr>
          <th style="padding: 0px">Terms of payment</th>
          <th style="padding: 0px">Date shift (days)</th>
          <th style="padding: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($pterms as $pterm)
        <tr>
          <td style="padding: 0px">{{$pterm->pterm}}</td>
          <td style="padding: 0px">{{$pterm->shift}}</td>
          <td style="padding: 0px"><a href="javscript::void()" onclick="delPaymentTerm({{$pterm->id}})">delete</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block">
  <label style="font-weight: normal"><input type="checkbox" checked>PDF attachement with embedded fonts (PDF size will be larger, but readable on all devices)</label><br>
  <label style="font-weight: normal"><input type="checkbox" @if($setting->invoice_lzcy) checked @endif name="invoice_lzcy" class="cs">Invoice numbering with leading zeros and current year</label><br>
  <label style="font-weight: normal"><input type="checkbox" @if($setting->order_lzcy) checked @endif name="order_lzcy" class="cs">Order numbering with leading zeros and current year</label><br>
  <label style="font-weight: normal"><input type="checkbox" @if($setting->estimate_lzcy) checked @endif name="estimate_lzcy" class="cs">Estimate numbering with leading zeros and current year</label><br>
  <label style="font-weight: normal"><input type="checkbox" @if($setting->porder_lzcy) checked @endif name="porder_lzcy" class="cs">Purchase order numbering with leading zeros and current year</label>
</div>