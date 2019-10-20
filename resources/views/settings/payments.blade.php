<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-12">
        <div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block">
          <div class="row">
            <div class="col-md-6">
              <label style="font-weight: normal"><input type="checkbox" @if($setting->payments1) checked @endif name="payments1" class="cs">Show "PAID" image on fully paid invoices</label><br>
            </div>
            <div class="col-md-6">
              <label style="font-weight: normal"><input type="checkbox" @if($setting->payments2) checked @endif name="payments2" class="cs">Insert "Pay Now" button with the remaining balance on unpaid PDF invoices</label>
            </div>
            <div class="col-md-6">
              <label style="font-weight: normal"><input type="checkbox" @if($setting->payments3) checked @endif name="payments3" class="cs">Send payment receipt email after payment recorded</label>
            </div>
            <div class="col-md-6">
              <label style="font-weight: normal"><input type="checkbox" @if($setting->payments4) checked @endif name="payments4" class="cs">Attach updated invoice to payment receipt email</label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block">
          Payment Receipt Text Labels
          <div style="font-size: 12px">
            <div class="row">
              <div class="col-md-6">
                <label>Payment Receipt <br><input type="text" style="width: 100%" class="rl" name="rl39" value="{{$rlables[38]->custom}}"></label><br>
                <label>Payment for Invoice# <br><input type="text" style="width: 100%" class="rl" name="rl41" value="{{$rlables[40]->custom}}"></label><br>
                <label>Amount received from: <br><input type="text" style="width: 100%" class="rl" name="rl43" value="{{$rlables[42]->custom}}"></label><br>
                <label>Description: <br><input type="text" style="width: 100%" class="rl" name="rl45" value="{{$rlables[44]->custom}}"></label><br>
                <label>Payment Received in: <br><input type="text" style="width: 100%" class="rl" name="rl47" value="{{$rlables[46]->custom}}"></label><br>
                <label>Payment Receipt# <br><input type="text" style="width: 100%" class="rl" name="rl49" value="{{$rlables[48]->custom}}"></label><br>
              </div>
              <div class="col-md-6">
                <label>Payment Date: <br><input type="text" style="width: 100%" class="rl" name="rl40" value="{{$rlables[39]->custom}}"></label><br>
                <label>Payment Amount: <br><input type="text" style="width: 100%" class="rl" name="rl42" value="{{$rlables[41]->custom}}"></label><br>
                <label>Total Amount Due: <br><input type="text" style="width: 100%" class="rl" name="rl44" value="{{$rlables[43]->custom}}"></label><br>
                <label>Total Paid: <br><input type="text" style="width: 100%" class="rl" name="rl46" value="{{$rlables[45]->custom}}"></label><br>
                <label>Balance Due: <br><input type="text" style="width: 100%" class="rl" name="rl48" value="{{$rlables[47]->custom}}"></label><br>
                <label>Payment Receipt Prefix <br><input type="text" style="width: 100%" name="payment_receipt_prefix" value="{{$setting->payment_receipt_prefix}}" class="cs"></label><br>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block">
          PAID Image for Invoices (max: 40mm x 25mm) 
          <div style="font-size: 12px">
            <image src="https://via.placeholder.com/400x250" /><br>
            <button>Load logo image...</button><button>Restore Default</button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block">
          PayNow Image for Invoices (max: 40mm x 10mm) 
          <div style="font-size: 12px">
            <image src="https://via.placeholder.com/400x100"/><br>
            <button>Load logo image...</button><button>Restore Default</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
