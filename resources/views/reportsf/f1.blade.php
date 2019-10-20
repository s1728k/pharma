<div class="col-md-2 col-xs-4">
  Category Filter:
  <select style="width: 150px;" name="c" class="f">
    <option @if($f['c'] == 'All') selected @endif>All</option>
    @foreach($cat as $c)
    <option  @if($f['c'] == $c) selected @endif>{{$c}}</option>
    @endforeach
  </select>
</div>
<div class="col-md-2 col-xs-6">
  Date period:
  <select style="width: 150px;" name="dp" class="f">
    <option @if($f['dp'] == 0) selected @endif value="0">Month to date</option>
    <option @if($f['dp'] == 1) selected @endif value="1">Year to date</option>
    <option @if($f['dp'] == 2) selected @endif value="2">Current year</option>
    <option @if($f['dp'] == 3) selected @endif value="3">Current month</option>
    <option @if($f['dp'] == 4) selected @endif value="4">Current day</option>
    <option @if($f['dp'] == 5) selected @endif value="5">Last 30 days</option>
    <option @if($f['dp'] == 6) selected @endif value="6">Last 60 days</option>
    <option @if($f['dp'] == 7) selected @endif value="7">Last 90 days</option>
    <option @if($f['dp'] == 8) selected @endif value="8">Previous month</option>
    <option @if($f['dp'] == 9) selected @endif value="9">Previous year</option>
    <option @if($f['dp'] == 10) selected @endif value="10">Custom range</option>
  </select>
{{--   <select style="width: 150px;" name="dp" class="f">
    <option @if($f['dp'] == 0) selected @endif value="0">Year to date</option>
    <option @if($f['dp'] == 1) selected @endif value="1">Current year</option>
    <option @if($f['dp'] == 2) selected @endif value="2">Current month</option>
    <option @if($f['dp'] == 3) selected @endif value="3">Last 3 months</option>
    <option @if($f['dp'] == 4) selected @endif value="4">Last 6 months</option>
    <option @if($f['dp'] == 5) selected @endif value="5">Last 12 months</option>
    <option @if($f['dp'] == 6) selected @endif value="6">Last 18 months</option>
    <option @if($f['dp'] == 7) selected @endif value="7">Last 24 months</option>
    <option @if($f['dp'] == 8) selected @endif value="8">Last 30 months</option>
    <option @if($f['dp'] == 9) selected @endif value="9">Previous year</option>
    <option @if($f['dp'] == 10) selected @endif value="10">Before Previous year</option>
    <option @if($f['dp'] == 11) selected @endif value="11">Custom range</option>
  </select> --}}
</div>
<div class="col-md-2 col-xs-6">
    <div class="row">
      <div class="col-md-2" style="padding:0px">
        From:
      </div>
      <div class="col-md-10" style="padding:0px">
        <input type="date" name="fd" value="{{$f['fd']}}" class="f">
      </div>
    </div>
    <div class="row">
      <div class="col-md-2" style="padding:0px">
        To:
      </div>
      <div class="col-md-10" style="padding:0px">
        <input type="date" name="td" value="{{$f['td']}}" class="f">
      </div>
    </div>
</div>
<div class="col-md-3 col-xs-12" >
  <div class="row">
    <div class="col-md-4 hide_in_mobile">
      <label style="font-weight: normal"><input type="checkbox" name="p" @if($f['p']) checked @endif class="f"> Paid</label>
      <label style="font-weight: normal"><input type="checkbox" name="v" @if($f['v']) checked @endif class="f"> Void</label>
    </div>
    <div class="col-xs-3 hide_in_pc">
      <label style="font-weight: normal"><input type="checkbox" name="p" @if($f['p']) checked @endif class="f"> Paid</label>
    </div>
    <div class="col-xs-3 hide_in_pc">
      <label style="font-weight: normal"><input type="checkbox" name="v" @if($f['v']) checked @endif class="f"> Void</label>
    </div>
    <div class="col-md-4 col-xs-3">
      <label style="font-weight: normal"><input type="checkbox" name="u" @if($f['u']) checked @endif class="f"> Unpaid</label>
    </div>
  </div>
</div>
