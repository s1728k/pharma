<div class="row">
<div class="col-md-2">
  <div style="border:1px solid grey;padding: 10px;margin: 10px;display: inline-block">
    Invoice# prefix 
    <div style="font-size: 12px; width:200px">
      <input type="text" style="width:100%;" name="invoice_prefix" value="{{$setting->invoice_prefix}}" class="cs">
    </div>
    Starting invoice number 
    <div style="font-size: 12px; width:200px">
      <input type="number" style="width:100%;" name="starting_invoice_no" value="{{$setting->starting_invoice_no}}" class="cs">
    </div>
  </div>
  <div style="border:1px solid grey;padding: 10px;margin: 10px;display: inline-block">
    Customize Invoice text lables
    <div style="width:200px; height: 45vh; overflow-y: scroll; background: white">
      <table class="table table-bordered table-custom">
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl1" value="{{$rlables[0]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl2" value="{{$rlables[1]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl3" value="{{$rlables[2]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl4" value="{{$rlables[3]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl5" value="{{$rlables[4]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl6" value="{{$rlables[5]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl7" value="{{$rlables[6]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl8" value="{{$rlables[7]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl9" value="{{$rlables[8]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl10" value="{{$rlables[9]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl11" value="{{$rlables[10]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl12" value="{{$rlables[11]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl13" value="{{$rlables[12]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl14" value="{{$rlables[13]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl15" value="{{$rlables[14]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl16" value="{{$rlables[15]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl17" value="{{$rlables[16]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl18" value="{{$rlables[17]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl19" value="{{$rlables[18]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl20" value="{{$rlables[19]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl21" value="{{$rlables[20]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl22" value="{{$rlables[21]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl23" value="{{$rlables[22]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl24" value="{{$rlables[23]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl25" value="{{$rlables[24]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl26" value="{{$rlables[25]->custom}}"></td></tr>
      </table>
    </div>
    <button>Restore Defaults</button>
  </div>
</div>
<div class="col-md-9">
  <div id="section-to-print" style="border: 1px solid black; background: lavender; padding: 10px;margin: 10px; height: 50vh; overflow-y:scroll; width: 100% ">
    @include('prints.invoice')
  </div>
  <div style="border:1px solid grey;padding: 10px;margin: 10px;display: inline-block; width: 100%">
    Predefined terms and conditions text for invoices 
    <div style="font-size: 12px; width:100%">
      <textarea rows="4" style="width:100%;" name="invoice_tctext" class="cs">{{$setting->invoice_tctext}}</textarea>
    </div>
  </div>
</div>
</div>