@if(in_array($id, [0,1,2,3,5,12,13,14,15,16,17,18,20,21]))
<div class="col-md-2">
  Category Filter:
  <select style="width: 150px;">
    <option>UnCategorized</option>
    @foreach($cat as $c)
    <option>{{$c}}</option>
    @endforeach
  </select>
</div>
@endif
@if(in_array($id, [7,8,14,16,17,18]))
<div class="col-md-3">
  Select customer category:
  <select style="width: 200px;">
    <option>All Customers</option>
  </select>
</div>
@endif
@if(in_array($id, [9,10]))
<div class="col-md-3">
  Select product category:
  <select style="width: 200px;">
    <option>All products and services</option>
    <option>All products</option>
    <option>All services</option>
  </select>
</div>
@endif
@if(in_array($id, [15]))
<div class="col-md-3">
  Select user name:
  <select style="width: 200px;">
    <option>Administrator</option>
  </select>
</div>
@endif
@if(in_array($id, [21]))
<div class="col-md-2">
  Select type:
  <select style="width: 150px;">
    <option>- All -</option>
    <option>- Internal -</option>
  </select>
</div>
@endif
@if($id == 0)
<div class="col-md-2">
  Date period:
  <select style="width: 150px;">
    <option>Year to date</option>
    <option>Current year</option>
    <option>Current month</option>
    <option>Last 3 months</option>
    <option>Last 6 months</option>
    <option>Last 12 months</option>
    <option>Last 18 months</option>
    <option>Last 24 months</option>
    <option>Last 30 months</option>
    <option>Previous year</option>
    <option>Before Previous year</option>
    <option>Custom range</option>
  </select>
</div>
@endif
@if(in_array($id, [1,2,3,6,12,13,20]))
<div class="col-md-2">
  Date period:
  <select style="width: 150px;">
    <option>Month to date</option>
    <option>Year to date</option>
    <option>Current year</option>
    <option>Current month</option>
    <option>Current day</option>
    <option>Last 30 days</option>
    <option>Last 60 days</option>
    <option>Last 90 days</option>
    <option>Previous month</option>
    <option>Previous year</option>
    <option>Custom range</option>
  </select>
</div>
@endif
@if(in_array($id, [0,1,2,3,6,12,13,14,15,16,17,18,20,21]))
<div class="col-md-2">
    <div class="row">
      <div class="col-md-2" style="padding:0px">
        From:
      </div>
      <div class="col-md-10" style="padding:0px">
        <input type="date">
      </div>
    </div>
    <div class="row">
      <div class="col-md-2" style="padding:0px">
        To:
      </div>
      <div class="col-md-10" style="padding:0px">
        <input type="date">
      </div>
    </div>
</div>
@endif
@if(in_array($id, [19]))
<div class="col-md-2">
    Day:<br>
    <input type="date">
</div>
@endif
@if($id == 0)
<div class="col-md-3" >
  <div class="row">
    <div class="col-md-6">
      <label style="font-weight: normal"><input type="checkbox"> Invoiced</label><br>
      <label style="font-weight: normal"><input type="checkbox"> Outstanding</label>
    </div>
    <div class="col-md-6">
      <label style="font-weight: normal"><input type="checkbox"> Paid</label>
    </div>
  </div>
</div>
@endif
@if(in_array($id, [1,2,12]))
<div class="col-md-3" >
  <div class="row">
    <div class="col-md-4">
      <label style="font-weight: normal"><input type="checkbox"> Paid</label><br>
      <label style="font-weight: normal"><input type="checkbox"> Void</label>
    </div>
    <div class="col-md-4">
      <label style="font-weight: normal"><input type="checkbox"> Unpaid</label>
    </div>
  </div>
</div>
@endif
@if(in_array($id, [7,8,9,10,11]))
<div class="col-md-3" >
  <div class="row">
    <div class="col-md-6">
      <label style="font-weight: normal"><input type="checkbox"> Active</label><br>
      <label style="font-weight: normal"><input type="checkbox"> Inactive</label>
    </div>
  </div>
</div>
@endif
@if(in_array($id, [20]))
<div class="col-md-3" >
  <div class="row">
    <div class="col-md-6">
      <label style="font-weight: normal"><input type="checkbox"> Completed</label><br>
      <label style="font-weight: normal"><input type="checkbox"> Draft</label>
    </div>
  </div>
</div>
@endif
@if(in_array($id, [21]))
<div class="col-md-3" >
  <div class="row">
    <div class="col-md-6">
      <label style="font-weight: normal"><input type="checkbox"> Invoiced</label><br>
      <label style="font-weight: normal"><input type="checkbox"> Rebillable</label>
    </div>
  </div>
</div>
@endif