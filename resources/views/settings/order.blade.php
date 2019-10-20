<div class="row">
<div class="col-md-2">
  <div style="border:1px solid grey;padding: 10px;margin: 10px;display: inline-block">
    Order# prefix 
    <div style="font-size: 12px; width:200px">
      <input type="text" style="width:100%;" name="order_prefix" value="{{$setting->order_prefix}}" class="cs">
    </div>
    Starting order number 
    <div style="font-size: 12px; width:200px">
      <input type="number" style="width:100%;" name="starting_order_no" value="{{$setting->starting_order_no}}" class="cs">
    </div>
  </div>
  <div style="border:1px solid grey;padding: 10px;margin: 10px;display: inline-block">
    Customize Order text lables
    <div style="width:200px; height: 45vh; overflow-y: auto; background: white">
      <table class="table table-bordered table-custom">
          <tr><td style="padding: 0px;"><input type="text"  class="rl" name="rl27" value="{{$rlables[26]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl28" value="{{$rlables[27]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl29" value="{{$rlables[28]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl30" value="{{$rlables[29]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl31" value="{{$rlables[30]->custom}}"></td></tr>
          <tr><td style="padding: 0px;"><input type="text" class="rl" name="rl32" value="{{$rlables[31]->custom}}"></td></tr>
      </table>
    </div>
    <button>Restore Defaults</button>
  </div>
</div>
<div class="col-md-9">
  <div id="section-to-print" style="border: 1px solid black; background: lavender; padding: 10px;margin: 10px; height: 50vh; overflow-y:scroll; width: 100% ">
    <div class="row" style="background: white; border: 1px solid black; width:1080px; height:1619px;margin:0 auto;position: relative;">
      <div class="col-md-12" style="display: inline-block;">
        <p style="text-align: center;">Title text goes here</p>
        <image src="https://via.placeholder.com/150x100" style="float: left">
        <div style="float: right; text-align: right">
          <h3>Vinayaka Pharmacy LLP</h3>
          <p>Bommasandra 1</p>
          <p>Bommasandra 2</p>
          <p>Bangalore 560099</p>
          <p>Phone 080 22211144</p>
          <p>GST: 6546sf45464fsd6</p>
        </div>
      </div>
      <div class="col-md-12" style="display: inline-block;">
        <div style="float: left">
          <div class="row">
            <div class="col-md-6">
              <p>Order#</p>
              <p>Order date</p>
              <p>Due date</p>
              <p>Terms</p>
              <p>Order ref.#</p>
            </div>
            <div class="col-md-6">
              <p>Order#</p>
              <p>Order date</p>
              <p>Due date</p>
              <p>Terms</p>
            </div>
          </div>
        </div>
        <div style="float: right">
          <h3>Order</h3>
          <p>Tax exempted</p>
        </div>
      </div>
      <div class="col-md-12" style="padding-right: 150px;padding-left: 150px;">
        <div class="row">
          <div class="col-md-6">
            <u>Bill to</u>
            <p>John Doe</p>
            <p>381 South Bedford Road</p>
            <p>Bedford Corners, NY 10549</p>
            <p>United States</p>
          </div>
          <div class="col-md-6">
            <u>Ship to</u>
            <p>John Doe</p>
            <p>381 South Bedford Road</p>
            <p>Bedford Corners, NY 10549</p>
            <p>United States</p>
          </div>
        </div>
      </div>
      <div class="col-md-12" style="display: inline-block;">
        <table class="table table-bordered" style="border-collapse: collapse;">
          <thead>
            <tr>
              <th>ID/SKU</th>
              <th>Product/Service - Description</th>
              <th>Quantity</th>
              <th>Unit Price</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>PROD-0001</td>
              <td>Example PROD - Description text ...</td>
              <td>1</td>
              <td>₹ 200.00</td>
              <td>₹ 200.00</td>
            </tr>
            <tr>
              <td colspan="2" style="visibility: hidden;"></td>
              <td colspan="2">Subtotal</td>
              <td>₹ 200.00</td>
            </tr>
            <tr>
              <td colspan="2" style="visibility: hidden;"></td>
              <td colspan="2">TAX 1</td>
              <td>₹ 18.00</td>
            </tr>
            <tr>
              <td colspan="2" style="visibility: hidden;"></td>
              <td colspan="2">TAX 2</td>
              <td>₹ 0.00</td>
            </tr>
            <tr>
              <td colspan="2" style="visibility: hidden;"></td>
              <td colspan="2">Shipping and handling</td>
              <td>₹ 20.00</td>
            </tr>
            <tr>
              <td colspan="2" style="visibility: hidden;"></td>
              <td colspan="2">Order total</td>
              <td>₹ 238.00</td>
            </tr>
            <tr>
              <td colspan="2" style="visibility: hidden;"></td>
              <td colspan="2">Total Paid</td>
              <td>₹ 100.00</td>
            </tr>
            <tr>
              <td colspan="2" style="visibility: hidden;"></td>
              <td colspan="2">Balance</td>
              <td>₹ 138.00</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-12" style="display: inline-block;">
        <p>Multiline comments goes here</p>
        <p>.....</p>
        <p>.....</p>
        <p>.....</p>
      </div>
      <div class="col-md-12" style="position: absolute;bottom: 30px;">
        <p style="text-align: center; border-bottom: 1px solid black;">Terms and Conditions</p>
        <p>Orders are payable on receipt unless other terms, negotiated and noted on the invoice. By accepting delivery of goods, Buyer agrees to pay the invoiced cost for those goods, and agrees to be bound to these contract terms. No acceptance may vary these terms unless specifically agreed in writing by Seller.</p>
      </div>
      <div class="col-md-6" style="position: absolute;bottom:0px;left:0px">
        <p>Page footer text goes here....</p>
      </div>
      <div class="col-md-6" style="position: absolute;bottom:0px;right:0px">
        <p style="float: right">Page 1 of 1</p>
      </div>
    </div>
  </div>
  <div style="border:1px solid grey;padding: 10px;margin: 10px;display: inline-block; width: 100%">
    Predefined terms and conditions text for invoices 
    <div style="font-size: 12px; width:100%">
      <textarea rows="4" style="width:100%;" name="order_tctext" class="cs">{{$setting->order_tctext}}</textarea>
    </div>
  </div>
</div>
</div>