<form id="company_setting" method="post" action="{{ route('settings.company') }}">
<div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block;">
  Company data
  <div style="width:440px; font-size: 12px">
    <div class="row">
      <div class="col-md-3">
        Company name
      </div>
      <div class="col-md-9">
        <input type="text" style="width: 100%; margin-bottom: 4px" name="company_name" value="{{$setting->company_name}}" class="cs">
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        Company address
      </div>
      <div class="col-md-9">
        <textarea rows="6" style="width: 100%; margin-bottom: 4px" name="company_address" class="cs">{{$setting->company_address}}</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        E-mail address
      </div>
      <div class="col-md-9">
        <input type="text" style="width: 100%; margin-bottom: 4px" name="email" value="{{$setting->email}}" class="cs">
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        Sales tax reg. no.
      </div>
      <div class="col-md-9">
        <input type="text" style="width: 100%; margin-bottom: 4px" name="sales_tax_reg_no" value="{{$setting->sales_tax_reg_no}}" class="cs">
      </div>
    </div>
  </div>
</div>
<div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block;">
  Currency
  <div style="width:440px; font-size: 12px">
    <div class="row">
      <div class="col-md-4">
        Currency: 
      </div>
      <div class="col-md-6">
        <select type="text" style="width: 30%; margin-bottom: 4px" onchange="curChange(this)" name="currency" class="cs">
          <option @if($setting->currency == 'INR') selected @endif>INR</option>
          <option @if($setting->currency == 'USD') selected @endif>USD</option>
          <option @if($setting->currency == 'EUR') selected @endif>EUR</option>
          <option @if($setting->currency == 'GBP') selected @endif>GBP</option>
          <option @if($setting->currency == 'CAD') selected @endif>CAD</option>
          <option @if($setting->currency == 'AUD') selected @endif>AUD</option>
          <option @if($setting->currency == 'JPN') selected @endif>JPN</option>
        </select>
        <input type="hidden" id="currency_sign" name="currency_sign" value="{{$setting->currency_sign}}" class="cs">
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        Currency sign: 
      </div>
      <div class="col-md-6">
        <span id="cur">{{$setting->currency_sign??'₹'}}</span>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        Currency sign placement
      </div>
      <div class="col-md-8">
        <select type="text" style="width: 60%; margin-bottom: 4px" name="currency_sign_placement" class="cs">
          <option value="0" @if($setting->currency_sign_placement == 0) selected @endif>Before amount</option>
          <option value="1" @if($setting->currency_sign_placement == 1) selected @endif>After amount</option>
          <option value="2" @if($setting->currency_sign_placement == 2) selected @endif>Before amount with space</option>
          <option value="3" @if($setting->currency_sign_placement == 3) selected @endif>After amount with space</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        Decimal separator
      </div>
      <div class="col-md-8">
        <select type="text" style="width: 30%; margin-bottom: 4px" name="decimal" class="cs">
          <option @if($setting->decimal == '.') selected @endif>.</option>
          <option @if($setting->decimal == ',') selected @endif>,</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        Example: 
      </div>
      <div class="col-md-8">
        <span id="ex">₹ 8,374.27</span>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-8">
        <button>Set Currency</button><button>Restore default</button>
      </div>
    </div>
  </div>
</div>
<div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block;">
  Tax name and rate
  <div style="width:440px; font-size: 12px">
    <div class="row">
      <div class="col-md-6">
        <div style="border: 1px solid #d1d1d1; padding: 10px;">
          Select TAX type:<br>
          <label style="font-weight: normal;"><input type="radio" name="tax_type" class="cs" value="0" onclick="taxClick(0)" @if($setting->tax_type == 0) checked @endif> Do not use TAX</label><br>
          <label style="font-weight: normal;"><input type="radio" name="tax_type" class="cs" value="1" onclick="taxClick(1)" @if($setting->tax_type == 1) checked @endif> 1 level of TAX</label><br>
          <label style="font-weight: normal;"><input type="radio" name="tax_type" class="cs" value="2" onclick="taxClick(2)" @if($setting->tax_type == 2) checked @endif> 2 levels of TAX</label>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-5 t1">
            Tax 1 name
          </div>
          <div class="col-md-7 t1">
            <input type="text" style="width: 100%; margin-bottom: 4px;" name="tax1_name" value="{{$setting->tax1_name}}" class="cs">
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 t1">
            Tax 1 rate
          </div>
          <div class="col-md-7 t1">
            <input type="number" style="width: 100%; margin-bottom: 4px;" name="tax1_rate" value="{{$setting->tax1_rate}}"  class="cs">
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 t2">
            Tax 2 name
          </div>
          <div class="col-md-7 t2">
            <input type="text" style="width: 100%; margin-bottom: 4px;" name="tax2_name" value="{{$setting->tax2_name}}"  class="cs">
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 t2">
            Tax 2 rate
          </div>
          <div class="col-md-7 t2">
            <input type="number" style="width: 100%; margin-bottom: 4px;" name="tax2_rate" value="{{$setting->tax2_rate}}"  class="cs">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <br>
        <lavel class="t1" style="font-weight: normal;"><input type="checkbox" @if($setting->print_tax1 == 1) checked @endif name="print_tax1" class="cs"> Print TAX1</lavel><br>
        <lavel class="t2" style="font-weight: normal;"><input type="checkbox" @if($setting->print_tax2 == 1) checked @endif name="print_tax2" class="cs"> Print TAX2</lavel>
      </div>
      <div class="col-md-9">
        <div class="t2" style="border: 1px solid #d1d1d1; padding: 10px;">
          Select TAX type:<br>
          <label style="font-weight: normal;"><input type="radio" name="tax2_type" class="cs" value="0" @if($setting->tax2_type == 0) checked @endif> TAX 2 based on invoice total only</label><br>
          <label style="font-weight: normal;"><input type="radio" name="tax2_type" class="cs" value="1" @if($setting->tax2_type == 1) checked @endif> TAX 2 based on invoice total + first tax</label>
        </div>
      </div>
    </div>
  </div>
</div>
<div style="border:1px solid grey; padding: 10px;margin: 10px;display: inline-block;">
  Company logo <br>
  <image src="https://via.placeholder.com/150x100"></image><br><br>
  <button>Load logo image</button><br><label style="font-weight: normal;"><input type="checkbox" @if($setting->print_logo_picture == 1) checked @endif name="print_logo_picture" class="cs">Print logo picture</label>
</div>
</form>