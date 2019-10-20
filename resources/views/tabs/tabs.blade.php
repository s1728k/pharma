<ul class="nav nav-tabs nav-custom">
  @if($ind == 0)
  <li class="active"><a data-toggle="tab" href="#items">Invoice Items ({{count($items)}})</a></li>
  <li><a data-toggle="tab" href="#payments">Payments ({{count($payments)}})</a></li>
  <li><a data-toggle="tab" href="#private_notes">Invoice Private Notes</a></li>
  <li><a data-toggle="tab" href="#smslog">SMS Log</a></li>
  <li><a data-toggle="tab" href="#documents">Documents (0)</a></li>
  @endif
  @if($ind == 1)
  <li class="active"><a data-toggle="tab" href="#items">Order Items ({{count($items)}})</a></li>
  <li><a data-toggle="tab" href="#private_notes">Private Notes</a></li>
  <li><a data-toggle="tab" href="#smslog">SMS Log</a></li>
  <li><a data-toggle="tab" href="#documents">Documents (0)</a></li>
  @endif
  @if($ind == 2)
  <li class="active"><a data-toggle="tab" href="#items">Estimate Items ({{count($items)}})</a></li>
  <li><a data-toggle="tab" href="#private_notes">Private Notes</a></li>
  <li><a data-toggle="tab" href="#smslog">SMS Log</a></li>
  <li><a data-toggle="tab" href="#documents">Documents (0)</a></li>
  @endif
  @if($ind == 3)
  <li class="active"><a data-toggle="tab" href="#items">P. Order Items ({{count($items)}})</a></li>
  <li><a data-toggle="tab" href="#private_notes">Private Notes</a></li>
  <li><a data-toggle="tab" href="#smslog">SMS Log</a></li>
  <li><a data-toggle="tab" href="#documents">Documents (0)</a></li>
  @endif
</ul>

<div class="tab-content">
  <div id="items" class="tab-pane fade in active">
    @include('tabs.items')
  </div>
  @if($ind == 0)
  <div id="payments" class="tab-pane fade">
    @include('tabs.payments')
  </div>
  @endif
  <div id="private_notes" class="tab-pane fade">
    <div class="row" style="margin-top: 10px">
      <div class="col-md-12">
        Private notes (not shown on order/estimate/purchase order)
        <textarea rows="6" style="width: 100%; margin-bottom: 4px" name="private_notes" class="i">{{$private_notes}}</textarea>
      </div>
    </div>
  </div>
  <div id="smslog" class="tab-pane fade">
    <div class="row" style="margin-top: 10px">
      <div class="col-md-12">
        <textarea rows="6" style="width: 100%; margin-bottom: 4px" name="sms_log" class="i"></textarea>
      </div>
    </div>
  </div>
  <div id="documents" class="tab-pane fade">
    <div class="row" style="margin-top: 10px">
      <div class="col-md-12">
        <p>Attached documents or image files. If you attach large files to invoice email then emails take long time to send. <button style="float: right">-</button><button style="float: right;">+</button></p>
        <table class="table table-bordered table-custom">
          <thead>
            <tr>
              <th style="padding: 0px; width: 100px">Attach to Email</th>
              <th style="padding: 0px">File name</th>
              <th style="padding: 0px">File size</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding: 0px"><input type="checkbox" style="margin: 0px" /></td>
              <td style="padding: 0px">data</td>
              <td style="padding: 0px">data</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>