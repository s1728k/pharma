@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row" style="margin-top: 10vh">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12">
          <div style="border:1px solid grey; padding: 10px;width: 100%; font-size: 12px;position: relative;">
            <span style="position: absolute;top:-10px;left:2px;background: #eee">Expense Cost</span><br>
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-md-3">
                Expense amount
              </div>
              <div class="col-md-3">
                <input type="number" style="width: 100%" name="amount" value="{{$e?$e->amount:''}}" class="e">
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-1">
                Date
              </div>
              <div class="col-md-4">
                <input type="date" style="width: 100%" name="date" value="{{$e?$e->date:''}}" class="e">
              </div>
            </div>
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-md-2">
                Vendor
              </div>
              <div class="col-md-5">
                    <div style="position:relative;width:100%;height:25px;border:0;padding:0;margin:0;">
      <select style="position:absolute;top:0px;left:0px;width:100%; height:22px;line-height:20px;margin:0;padding:0;"
      onchange="document.getElementById('displayValue').value=this.options[this.selectedIndex].text; document.getElementById('idValue').value=this.options[this.selectedIndex].value;" name="vendor" class="e">
      <option></option>
      @foreach($customers as $customer)
      @if($customer->customer_type == 1 || $customer->customer_type == 2)
      <option>{{$customer->bname}}</option>
      @endif
      @endforeach
      </select>
      <input type="text" id="displayValue" 
      placeholder="add/select a value" onfocus="this.select()"
      style="position:absolute;top:0px;left:0px;width:185px;height:22px; border:1px solid #aaa;"  name="vendor" value="{{$e?$e->vendor:''}}" class="e">
      <input name="idValue" id="idValue" type="hidden">
      </div>
              </div>
              <div class="col-md-1">
                    Category
              </div>
              <div class="col-md-4">
                    <select style="width: 100%" name="category" class="e"><option>Default</option></select>
              </div>
            </div>
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-md-2">
                Description
              </div>
              <div class="col-md-10">
                <input type="text" style="width: 100%" class="e p" name="description" value="{{$e?$e->description:''}}">
              </div>
            </div>
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-md-2" style="padding-right: 0px">
                Staff member
              </div>
              <div class="col-md-4">
                <input type="text" style="width: 100%" class="e" name="staff_member" value="{{$e?$e->staff_member:''}}">
              </div>
              @if($setting->tax_type != 0)
              <div class="col-md-3">
                <label><input type="checkbox" class="e" name="tax1" @if(($e?$e->tax1:'') == 1) checked @endif>Taxable Tax1 rate</label>
              </div>
              @endif
              @if($setting->tax_type == 2)
              <div class="col-md-3">
                <label><input type="checkbox" class="e" name="tax2" @if(($e?$e->tax2:'') == 1) checked @endif>Taxable Tax2 rate</label>
              </div>
              @endif
            </div>
            <div class="row">
              <div class="col-md-6">
                <label><input type="checkbox" onclick="assignToCustomer(this)" class="e" name="assign_to_customer" @if(($e?$e->assign_to_customer:'') == 1) checked @endif>Assign to Customer (optional)</label><br>
                <select style="width: 100%" class="e a" name="customer_name">
                  @foreach($customers as $customer)
                  <option @if(($e?$e->customer_name:'') == $customer->bname) selected @endif>{{$customer->bname}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <label class="a"><input type="checkbox" onclick="rebillToCustomer(this)" class="e" name="rebillable" @if(($e?$e->rebillable:'') == 1) checked @endif>Rebillable</label>
              </div>
              <div class="col-md-4" >
                <div class="row" style="margin-bottom: 10px;">
                  <div class="col-md-3">
                    <label class="b">ID/SKU</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" style="width: 100%" class="e b" name="code" value="{{$e?$e->code:''}}">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label class="b">Rebill amount</label>
                  </div>
                  <div class="col-md-9">
                    <input type="number" style="width: 100%" class="e b" name="rebill_amount" value="{{$e?$e->rebill_amount:''}}">
                  </div>
                </div>
              </div>
            </div>
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-md-12">
                <label><input type="checkbox" onclick="attachReceipt(this)" name="attach_receipt_image" @if(($e?$e->attach_receipt_image:'') == 1) checked @endif class="e"> Attach receipt image (optional, image will be stored to the database)</label>
              </div>
            </div>
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-md-8" id="notes">
                <input type="file" style="width: 100%" class="c">
                Notes
                <textarea rows="6" style="width: 100%" name="notes" class="e">{{$e?$e->notes:''}}</textarea>
              </div>
              <div class="col-md-4" >
                <image src="https://via.placeholder.com/200x150" style="width: 100%; height: 150px;" class="c">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 text-left">
          <button type="button">OK</button>
        </div>
        <div class="col-md-6 text-right">
          <button type="button" onclick="cancel()">Back</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function assignToCustomer(e){
    if($(e).prop('checked')){
      $('.a').css('visibility','visible');
    }else{
      $('.a').css('visibility','hidden');
      $('.b').css('visibility','hidden');
    }
  }
  function rebillToCustomer(e){
    if($(e).prop('checked')){
      $('.b').css('visibility','visible');
    }else{
      $('.b').css('visibility','hidden');
    }
  }
  function attachReceipt(e){
    if($(e).prop('checked')){
      $('#notes').removeClass('col-md-12').addClass('col-md-8');
      $('.c').show();
    }else{
      $('.c').hide();
      $('#notes').removeClass('col-md-8').addClass('col-md-12');
    }
  }
  $('.a').css('visibility','hidden');
  $('.b').css('visibility','hidden');
  $('.c').hide();
  $('#notes').removeClass('col-md-8').addClass('col-md-12');

  function cancel(){
    window.location="{{route("expense.index")}}"
  }

  var id = {{$id}};

  $(".e").on('change', function(){
    var p = {"_token":"{{csrf_token()}}"};
    if(id!=0){
      p['id']=id
    }

    if(this.type=='checkbox'){
      p[this.name]=$("[name='"+this.name+"']").prop('checked')?1:0;
    }else{
      p[this.name]=this.value;
    }


    $.post("{{ route('expense.save') }}",p,function(id,status){
      if(status=='success'){
        if(id!=0){
          window.location = "{{route("expense.view")}}/"+id
        }
      }
    });
  });
</script>
@endsection
