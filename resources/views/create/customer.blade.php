@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div id="alrt"></div>
  @if($errors->has('name'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('name')}}</div>@endif
  @if($errors->has('id'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('id')}}</div>@endif


	<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div style="border:1px solid grey; padding: 10px;display: inline-block; width: 100%;">
        Customer
        <div style="font-size: 12px">
          <div class="row">
            <div class="col-md-2">
              Customer ID:
            </div>
            <div class="col-md-3">
              <input type="text" style="width: 100%; margin-bottom: 4px" name="customer_id" value="{{$c?$c->customer_id:''}}" class="c">
            </div>
            <div class="col-md-2" style="text-align: right;">
              Category:
            </div>
            <div class="col-md-3">
              <div style="position:relative;width:100%;height:25px;border:0;padding:0;margin:0;">
<select style="position:absolute;top:0px;left:0px;width:100%; height:22px;line-height:20px;margin:0;padding:0;"
      onchange="document.getElementById('displayValue').value=this.options[this.selectedIndex].text; document.getElementById('idValue').value=this.options[this.selectedIndex].value;" name="category" class="c">
<option></option>
@foreach($categories as $cat)
<option>{{$cat}}</option>
@endforeach
</select>
<input type="text" id="displayValue" 
     placeholder="add/select a value" onfocus="this.select()"
     style="position:absolute;top:0px;left:0px;width:136px;height:22px; border:1px solid #aaa;"  name="category" value="{{$c?$c->category:''}}" class="c">
<input name="idValue" id="idValue" type="hidden">
</div>
            </div>
            <div class="col-md-2">
              Status: <label><input type="checkbox" name="status" @if($c?$c->status:0) checked @endif class="c">Active</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div style="border:1px solid grey; padding: 10px;display: inline-block; width: 100%">
                <p>Invoice to (appears on invoices)</p>
                <div class="row">
                  <div class="col-md-4">
                    Business name:
                  </div>
                  <div class="col-md-8">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="bname" value="{{$c?$c->bname:''}}" class="a1 c">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    Address:
                  </div>
                  <div class="col-md-9">
                    <textarea rows="4" style="width: 100%;" name="baddress" class="a1 c">{{$c?$c->baddress:''}}</textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div style="border:1px solid grey; padding: 10px;display: inline-block; width: 100%">
                <p>Ship to (appears on invoices)<button style="float: right" onclick="copyFromLeft1()">Copy form left</button></p>
                <div class="row">
                  <div class="col-md-4">
                    Ship to name:
                  </div>
                  <div class="col-md-8">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="sname" value="{{$c?$c->sname:''}}" class="a2 c">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    Address:
                  </div>
                  <div class="col-md-9">
                    <textarea rows="4" style="width: 100%;" name="saddress" class="a2 c">{{$c?$c->saddress:''}}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-6">
              <div style="border:1px solid grey; padding: 10px;display: inline-block; width: 100%">
                <p>Contact</p>
                <div class="row">
                  <div class="col-md-4">
                    Contact person:
                  </div>
                  <div class="col-md-8">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="bcontact_person" value="{{$c?$c->bcontact_person:''}}" class="b1 c">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    Email address:
                  </div>
                  <div class="col-md-8">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="bemail" value="{{$c?$c->bemail:''}}" class="b1 c">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    Tel.no:
                  </div>
                  <div class="col-md-4">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="btel" value="{{$c?$c->btel:''}}" class="b1 c">
                  </div>
                  <div class="col-md-2">
                    Fax:
                  </div>
                  <div class="col-md-4">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="bfax" value="{{$c?$c->bfax:''}}" class="b1 c">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Mobile number for sms notification:
                  </div>
                  <div class="col-md-4">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="bmobile" value="{{$c?$c->bmobile:''}}" class="c">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div style="border:1px solid grey; padding: 10px;display: inline-block; width: 100%">
                <p>Ship to contact <button style="float: right" onclick="copyFromLeft2()">Copy form left</button></p>
                <div class="row">
                  <div class="col-md-4">
                    Contact person:
                  </div>
                  <div class="col-md-8">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="scontact_person" value="{{$c?$c->scontact_person:''}}" class="b2 c">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    Email address:
                  </div>
                  <div class="col-md-8">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="semail" value="{{$c?$c->semail:''}}" class="b2 c">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    Tel.no:
                  </div>
                  <div class="col-md-4">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="stel" value="{{$c?$c->stel:''}}" class="b2 c">
                  </div>
                  <div class="col-md-2">
                    Fax:
                  </div>
                  <div class="col-md-4">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="sfax" value="{{$c?$c->sfax:''}}" class="b2 c">
                  </div>
                </div>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-6">
              <div style="border:1px solid grey; padding: 10px;display: inline-block; width: 100%">
                <p>Payment options</p>
                <div class="row">
                  <div class="col-md-6">
                    <label><input type="checkbox" name="tax_exempt" @if($c?$c->tax_exempt:0) checked @endif class="c">Tax Exempt</label>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6" style="padding: 0px">
                        Specific Tax1 %: 
                      </div>
                      <div class="col-md-6">
                        <input type="number" style="width: 100%; margin-bottom: 4px" name="tax1_rate" value="{{$c?$c->tax1_rate:''}}" class="c">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6" style="padding-right: 0px">
                        Discount %: 
                      </div>
                      <div class="col-md-6">
                        <input type="number" style="width: 100%; margin-bottom: 4px" name="discount" value="{{$c?$c->discount:''}}" class="c">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6" style="padding: 0px">
                        Specific Tax2 %: 
                      </div>
                      <div class="col-md-6">
                        <input type="number" style="width: 100%; margin-bottom: 4px" name="tax2_rate" value="{{$c?$c->tax2_rate:''}}" class="c">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div style="border:1px solid grey; padding: 10px;display: inline-block; width: 100%">
                <p>Additional info</p>
                <div class="row">
                  <div class="col-md-4">
                    Country:
                  </div>
                  <div class="col-md-8">
                    <select type="text" style="width: 100%; margin-bottom: 4px;height: 24px" name="country" class="c">
                      <option @if(($c?$c->country:'') == 'India') selected @endif>India</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    City:
                  </div>
                  <div class="col-md-8">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="city" value="{{$c?$c->city:''}}" class="c">
                  </div>
                </div>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-6">
              <div style="border:1px solid grey; padding: 10px;display: inline-block; width: 100%">
                <p>Customer type</p>
                <div class="row">
                  <div class="col-md-3"><label><input type="radio" @if(($c?$c->customer_type:'') == 0) checked @endif name="customer_type" value="0" class="c">Client</label></div>
                  <div class="col-md-3"><label><input type="radio" @if(($c?$c->customer_type:'') == 1) checked @endif name="customer_type" value="1" class="c">Vendor</label></div>
                  <div class="col-md-6"><label><input type="radio" @if(($c?$c->customer_type:'') == 2) checked @endif name="customer_type" value="2" class="c">Both (Client/Vendor)</label></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div style="border:1px solid grey; padding: 10px;display: inline-block; width: 100%">
                <p>Notes</p>
                <textarea rows="2" style="width: 100%" name="notes" class="c">{{$c?$c->notes:''}}</textarea>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-12">
              <button>Save</button><button style="float:right" onclick="cancel()">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function cancel(){
    window.location="{{route("customer.index")}}"
  }

  var id = {{$id}};

  $(".c").on('change', function(){
    var p = {"_token":"{{csrf_token()}}"};
    if(id!=0){
      p['id']=id
    }
    if(this.type=='checkbox'){
      p[this.name]=$("[name='"+this.name+"']").prop('checked')?1:0;
    }else{
      p[this.name]=this.value;
    }
    $.post("{{ route('customer.save') }}",p,function(id,status){
      if(status=='success'){
        if(id!=0){
          window.location="{{route("customer.view")}}/"+id;
        }
      }
    });
  });

  function copyFromLeft1(){
    $('.a1').each(function(i) {
        $('.a2').eq(i).val(this.value);
        $('.a2').eq(i).trigger("change");
    });
  }

  function copyFromLeft2(){
    $('.b1').each(function(i) {
        $('.b2').eq(i).val(this.value);
        $('.b2').eq(i).trigger("change");
    });
  }

</script>
@endsection