@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div id="alrt"></div>
  @if($errors->has('name'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('name')}}</div>@endif
  @if($errors->has('id'))<div class="alert alert-warning"><strong>Warning!</strong> {{$errors->first('id')}}</div>@endif
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8" style="border:1px solid gray">
      <div class="row menu-bar">
        <div class="col-md-12">
          <div class="btn-group btn-group-custom">
            <button class="menu_button" onclick="customerDialog()"><i class="fa fa-user-plus"></i><br> Select<br>Customer</button>
            <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
            <button class="menu_button" onclick="productDialog()"><i class="fa fa-plus-square-o"></i><br> Add new<br>line item</button>
            <button class="menu_button" onclick="deleteItems()"><i class="fa fa-remove"></i><br> Delete line<br>item</button>
            <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
            <button class="menu_button" onclick="printView()"><i class="fa fa-search-plus"></i><br> Preview<br>P. Order</button>
            <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-print"></i><br> Print<br>P. Order</button>
            <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
            <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-envelope-o"></i><br> E-mail<br>P. Order</button>
            <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-commenting-o"></i><br> Send SMS<br>Notification</button>
            <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
            <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-qrcode"></i><br> Mark porder<br>as 'Paid'</button>
            <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
            <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-low-vision"></i><br> Void<br>P. Order</button>
            <div class="hide_in_mobile" style="border-left:2px solid grey;height:66px; margin:2px;"></div>
            <button class="menu_button" data-toggle="modal" data-target="#createNewApp"><i class="fa fa-calculator"></i><br> Open<br>Calculator</button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <div style="border:1px solid grey; padding: 10px; margin-top: 10px;display: inline-block; width: 100%; font-size: 12px;position: relative;">
            <span style="position: absolute;top:-8px;left:10px;background: #eee">Customer {{$i->vendor_id?'(ID: '.$i->vendor_id.')':''}}</span>
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-3" style="padding-right: 0px">
                    <strong>Vendor:</strong>
                  </div>
                  <div class="col-md-9">
                    <select type="text" style="width: 100%; margin-bottom: 4px" name="vendor" class="i a1">
                      <option></option>
                      @foreach($customers as $customer)
                      <option @if($i->vendor == $customer->bname) selected @endif value="{{$customer->id}}">{{$customer->bname}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    Address
                    <button>Unbilled expenses</button>
                  </div>
                  <div class="col-md-9">
                    <textarea rows="3" style="width: 100%; margin-bottom: 4px" name="iaddress" class="i a1">{{$i->vaddress}}</textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-3">
                    <strong>Delivery to:</strong>
                  </div>
                  <div class="col-md-9">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="ship_to" value="{{$i->delivery_to}}" class="i a2">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    Address
                    <button onclick="copyFromLeft()">=></button>
                  </div>
                  <div class="col-md-9">
                    <textarea rows="3" style="width: 100%; margin-bottom: 4px" name="saddress" class="i a2">{{$i->daddress}}</textarea>
                  </div>
                </div>
              </div>
            </div>
            <hr style="border-top: 1px solid grey; margin: 4px; margin-bottom: 10px;">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-3">
                    Email:
                  </div>
                  <div class="col-md-9">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="iemail" value="{{$i->vemail}}" class="i">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-3" style="padding-right: 0px">
                    Mobile no.:
                  </div>
                  <div class="col-md-9">
                    <input type="text" style="width: 100%; margin-bottom: 4px" name="iphone" value="{{$i->vphone}}" class="i">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div style="border:1px solid grey; padding: 10px; margin-top: 10px;display: inline-block; width: 100%; font-size: 12px; position: relative;">
            <span style="position: absolute;top:-8px;left:10px;background: #eee">P. Order</span>
            <div class="row">
              <div class="col-md-3" style="padding-right: 0px">
                P. Order#
              </div>
              <div class="col-md-9">
                <input type="text" style="width: 100%; margin-bottom: 4px" name="porder_no" value="{{$i->porder_no}}" class="i">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3" style="padding-right: 0px">
                P. Order date
              </div>
              <div class="col-md-9">
                <input type="date" style="width: 100%; margin-bottom: 4px" name="porder_date" value="{{$i->porder_date}}" class="i">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3" style="padding-right: 0px">
                <label><input type="checkbox" name="due_date_req" @if($i->due_date_req) checked @endif class="i"> Due date</label>
              </div>
              <div class="col-md-9">
                <input type="date" style="width: 100%; margin-bottom: 4px" name="due_date" value="{{$i->due_date}}" class="i">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3" style="padding-right: 0px">
                Terms
              </div>
              <div class="col-md-9">
                <select type="text" style="width: 100%; margin-bottom: 4px" name="pterms" class="i">
                  <option></option>
                  @foreach($pterms as $pterm)
                  <option @if($i->pterms == $pterm->pterm) selected @endif>{{$pterm->pterm}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3" style="padding-right: 0px">
                Order ref.#
              </div>
              <div class="col-md-9">
                <input type="text" style="width: 100%; margin-bottom: 4px" name="order_ref_no" value="{{$i->order_ref_no}}" class="i">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div style="border:1px solid grey ;height: 210px; margin-top: 10px; overflow-y: auto;">
            <table class="table table-bordered table-custom">
              <thead>
                <tr>
                  <th style="padding: 0px;width: 2%"></th>
                  <th style="padding: 0px;width: 3%">ID/SKU</th>
                  <th style="padding: 0px;width: 15%">Product/Service</th>
                  <th style="padding: 0px;width: 23%">Description</th>
                  <th style="padding: 0px;width: 5%">Unit Price</th>
                  <th style="padding: 0px;width: 2%">Quantity</th>
                  <th style="padding: 0px;width: 3%">Pcs/Weight</th>
                  @if($setting->tax_type != 0)
                  <th style="padding: 0px;width: 1%">Tax1</th>
                  @endif
                  @if($setting->tax_type == 2)
                  <th style="padding: 0px;width: 1%">Tax2</th>
                  @endif
                  <th style="padding: 0px;width: 5%">Price</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $item)
                <tr id="r{{$item->id}}">
                  <td style="text-align:center; padding: 0px"><input type="checkbox" style="margin: 0px" onclick="selectP({{$item->id}})" /></td>
                  <td style="padding: 0px">{{$item->code}}</td>
                  <td style="padding: 0px">
                    <input type="text" style="width:100%; height: 16px; text-align: left;" name="i1j{{$item->id}}" value="{{$item->product}}" class="q"></td>
                  <td style="padding: 0px">
                    <input type="text" style="width:100%; height: 16px; text-align: left;" name="i2j{{$item->id}}" value="{{$item->description}}" class="q"></td>
                  <td style="padding: 0px">
                    <input type="number" style="width:100%; height: 16px; text-align: left;" name="i3j{{$item->id}}" value="{{$item->unit_price}}" class="q"></td>
                  <td style="padding: 0px;text-align: center;">
                    <input type="number" style="width:100%; height: 16px; text-align: left;" name="i4j{{$item->id}}" value="{{$item->quantity}}" class="q"></td>
                  <td style="padding: 0px">
                    <input type="number" style="width:100%; height: 16px; text-align: left;" name="i5j{{$item->id}}" value="{{$item->weight}}" class="q"></td>
                  @if($setting->tax_type != 0)
                  <td style="padding: 0px; text-align: center;">
                    <input type="checkbox" style="margin: 0px;" name="i6j{{$item->id}}" @if($item->tax1_rate) checked @endif class="q"></td>
                  @endif
                  @if($setting->tax_type == 2)
                  <td style="padding: 0px; text-align: center;">
                    <input type="checkbox" style="margin: 0px;" name="i7j{{$item->id}}" @if($item->tax2_rate) checked @endif class="q"></td>
                  @endif
                  <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($item->price,2)}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div style="border:1px solid grey;border-top: none;font-size: 12px; height: 16px;">
            <span style="float:left">Lines: {{count($items)}}</span>
            <span style="float:right">Price: {{$i->sum}}</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-9">
          <div style="border:1px solid grey; padding: 10px; margin-top: 10px;margin-bottom: 10px;; width: 100%; font-size: 12px">
            <ul class="nav nav-tabs nav-custom3">
              <li class="active"><a data-toggle="tab" href="#porder">P. Order</a></li>
              <li><a data-toggle="tab" href="#hfooter">Header/Footer</a></li>
              <li><a data-toggle="tab" href="#comments">Comments</a></li>
              <li><a data-toggle="tab" href="#terms">Terms</a></li>
              <li><a data-toggle="tab" href="#notes">Private notes</a></li>
              <li><a data-toggle="tab" href="#documents">Documents (0)</a></li>
            </ul>

            <div class="tab-content">
              <div id="porder" class="tab-pane fade in active">
                <div class="row">
                  <div class="col-md-9" style="padding-top:10px">
                    <div class="row">
                      <div class="col-md-3" style="text-align: right;">
                        Discount rate:
                      </div>
                      <div class="col-md-2">
                        <input type="number" style="width: 100%; margin-bottom: 4px" name="discount_rate" value="{{$i->discount_rate}}" class="i">
                      </div>
                      <div class="col-md-1"></div>
                      @if($setting->tax_type != 0)
                      <div class="col-md-1">
                        {{$setting->tax1_name}}:
                      </div>
                      <div class="col-md-2">
                        <input type="number" style="width: 100%; margin-bottom: 4px" name="tax1_rate" value="{{$i->tax1_rate}}" class="i">
                      </div>
                      @endif
                      @if($setting->tax_type == 2)
                      <div class="col-md-1" style="text-align: right;">
                        {{$setting->tax2_name}}:
                      </div>
                      <div class="col-md-2">
                        <input type="number" style="width: 100%; margin-bottom: 4px" name="tax2_rate" value="{{$i->tax2_rate}}" class="i">
                      </div>
                      @endif
                    </div>
                    <div class="row">
                      <div class="col-md-3" style="text-align: right;">
                        Extra cost name:
                      </div>
                      <div class="col-md-5">
                        <select type="text" style="width: 100%; margin-bottom: 4px" name="extra_cost_name" class="i">
                          <option></option>
                          @foreach($extra_costs as $extra_cost)
                          <option @if($i->extra_cost_name == $extra_cost->name) selected @endif>{{$extra_cost->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-2" style="text-align: right;">
                        Extra cost:
                      </div>
                      <div class="col-md-2">
                        <input type="number" style="width: 100%; margin-bottom: 4px" name="extra_cost" value="{{$i->extra_cost}}" class="i">
                      </div>
                    </div><div class="row">
                      <div class="col-md-3" style="text-align: right;">
                        Template:
                      </div>
                      <div class="col-md-6">
                        <select type="text" style="width: 100%; margin-bottom: 4px" name="template" class="i">
                          <option @if($i->template == '') selected @endif>fdsfsdfs</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3" style="text-align: right;">
                        Sales person:
                      </div>
                      <div class="col-md-3">
                        <input type="text" style="width: 100%; margin-bottom: 4px" name="sales_person" value="{{$i->sales_person}}" class="i">
                      </div>
                      <div class="col-md-3" style="text-align: right;">
                        Category:
                      </div>
                      <div class="col-md-3">
                        <input type="text" style="width: 100%; margin-bottom: 4px" name="category" value="{{$i->category}}" class="i">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div style="border:1px solid grey; padding: 10px; margin-top: 10px; width: 100%; font-size: 12px; position: relative;">
                      <span style="position: absolute;top:-8px;left:10px;background: #eee">Status</span>
                      <h2 style="font-size: 20; font-weight: bold; color:pink">{{$i->status}}</h2>
                      Emailed on: never<br>
                      Printed on: never
                    </div>
                  </div>
                </div>
              </div>
              <div id="hfooter" class="tab-pane fade">
                <div class="row" style="margin-top: 10px">
                  <div class="col-md-2" style="text-align: right;">
                    Title text
                  </div>
                  <div class="col-md-10">
                    <select type="text" style="width: 100%; margin-bottom: 4px" name="title_text" class="i">
                      <option></option>
                      @foreach($hfooters as $hfooter)
                      <option @if($i->title_text == $hfooter->hf_text) selected @endif>{{$hfooter->hf_text}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2" style="text-align: right;">
                    Page header text
                  </div>
                  <div class="col-md-10">
                    <select type="text" style="width: 100%; margin-bottom: 4px" name="page_header_text" class="i">
                      <option></option>
                      @foreach($hfooters as $hfooter)
                      <option @if($i->page_header_text == $hfooter->hf_text) selected @endif>{{$hfooter->hf_text}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2" style="text-align: right;">
                    Footer text
                  </div>
                  <div class="col-md-10">
                    <select type="text" style="width: 100%; margin-bottom: 4px" name="footer_text" class="i">
                      <option></option>
                      @foreach($hfooters as $hfooter)
                      <option @if($i->footer_text == $hfooter->hf_text) selected @endif>{{$hfooter->hf_text}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div id="comments" class="tab-pane fade">
                <div class="row" style="margin-top: 10px">
                  <div class="col-md-12">
                    <textarea rows="7" style="width: 100%; margin-bottom: 4px" name="comments" class="i">{{$i->comments}}</textarea>
                  </div>
                </div>
              </div>
              <div id="terms" class="tab-pane fade">
                <div class="row" style="margin-top: 10px">
                  <div class="col-md-12">
                    <textarea rows="7" style="width: 100%; margin-bottom: 4px" name="terms" class="i">{{$i->terms}}</textarea>
                  </div>
                </div>
              </div>
              <div id="notes" class="tab-pane fade">
                <div class="row" style="margin-top: 10px">
                  <div class="col-md-12">
                    Private notes (not shown on order/porder/purchase order)
                    <textarea rows="6" style="width: 100%; margin-bottom: 4px" name="private_notes" class="i">{{$i->private_notes}}</textarea>
                  </div>
                </div>
              </div>
              <div id="documents" class="tab-pane fade">
                <div class="row" style="margin-top: 10px">
                  <div class="col-md-12">
                    <p>Attached documents or image files. If you attach large files to porder email then emails take long time to send. <button style="float: right">-</button><button style="float: right;">+</button></p>
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
          </div>
        </div>
        <div class="col-md-3">
          <div style="border:1px solid grey; padding: 10px; margin-top: 10px;margin-bottom: 10px;; width: 100%; font-size: 12px">
            <p>Summary <button style="float: right" onclick="moveupItem()">LineUp</button><button style="float: right" onclick="movedownItem()">LineDown</button></p>
            <table class="table table-bordered table-custom">
              <tbody>
                <tr>
                  <td style="padding: 0px">{{$i->discount_rate}}% Discount</td>
                  <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($i->discount,2)}}</td>
                </tr>
                <tr>
                  <td style="padding: 0px">Subtotal</td>
                  <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($i->subtotal,2)}}</td>
                </tr>
                @if($setting->tax_type != 0)
                <tr>
                  <td style="padding: 0px">{{$setting->tax1_name}}</td>
                  <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($i->tax1,2)}}</td>
                </tr>
                @endif
                @if($setting->tax_type == 2)
                <tr>
                  <td style="padding: 0px">{{$setting->tax2_name}}</td>
                  <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($i->tax2,2)}}</td>
                </tr>
                @endif
                <tr>
                  <td style="padding: 0px">{{$i->extra_cost_name??'Extra cost'}}</td>
                  <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($i->extra_cost,2)}}</td>
                </tr>
                <tr>
                  <td style="padding: 0px">P. Order total</td>
                  <td style="padding: 0px">{{$setting->currency_sign}} {{number_format($i->porder_total,2)}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  function customerDialog(){
    window.location = "{{ route('customer.filter',['ind'=>3,'id'=>$i->id]) }}";
  }

  function productDialog(){
    window.location = "{{ route('product.filter',['ind'=>3,'id'=>$i->id]) }}";
  }

  $(".i").on('change', function(){
    var p = {"_token":"{{csrf_token()}}"};
    p['id']={{$i->id}};

    if(this.type=='checkbox'){
      p[this.name]=$("[name='"+this.name+"']").prop('checked')?1:0;
    }else{
      p[this.name]=this.value;
    }

    $.post("{{ route('porder.save') }}",p,function(data,status){
      if(status=='success'){
        if(data!=0){
          window.location = "{{ route('porder.new') }}/"+data;
        }
      }
    });
  });

  function copyFromLeft(){
    $('.a1').each(function(i) {
        $('.a2').eq(i).val(this.value);
        $('.a2').eq(i).trigger("change");
    });
  }

  $(".q").on('change', function(){
    var p = {"_token":"{{csrf_token()}}"};
    p['param']=this.name;
    p['id']={{$i->id}};
    p['ind']=3;
    if(this.type=='checkbox'){
      p['value']=$("[name='"+this.name+"']").prop('checked')?1:0;
    }else{
      p['value']=this.value;
    }
    $.post("{{ route('item.save') }}",p,function(data,status){
      if(status=='success'){
        if(data!=0){
          window.location = "{{ route('porder.new') }}/"+data;
        }
      }
    });
  });

  var s = [];
  function selectP(id){
    if(s.indexOf(id)!=-1){
      s.splice(s.indexOf(id),1);
    }else{
      s.push(id);
    }
  }

  function deleteItems(){
    var p = {'_token':"{{csrf_token()}}"};
    p['items'] = s;
    p['ind'] = 3;
    p['id'] = {{$i->id}};
    $.post("{{ route('item.delete') }}",p,function(items,status){
      if(status == 'success'){
        window.location = "{{ route('porder.new') }}/{{$i->id}}";
      }
    });
  }

  function moveupItem(){
    var p = {'_token':"{{csrf_token()}}"};
    p['items'] = s;
    p['doc_ref_no'] = 'P{{$i->id}}';
    $.post("{{ route('item.moveup') }}",p,function(data,status){
      if(status == 'success'){
        if(data!=0){
          window.location = "{{ route('porder.new') }}/{{$i->id}}";
        }
      }
    });
  }

  function movedownItem(){
    var p = {'_token':"{{csrf_token()}}"};
    p['items'] = s;
    p['doc_ref_no'] = 'P{{$i->id}}';
    $.post("{{ route('item.movedown') }}",p,function(data,status){
      if(status == 'success'){
        if(data!=0){
          window.location = "{{ route('porder.new') }}/{{$i->id}}";
        }
      }
    });
  }

  function printView(){
    window.location = "{{ route('print.view', ['ind'=>3,'id'=>$i->id]) }}";
  }
</script>


@endsection