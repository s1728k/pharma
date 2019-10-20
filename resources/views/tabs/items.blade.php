<div style="border:1px solid grey; margin-top: 10px; overflow-y: auto;">
  <table class="table table-bordered table-custom">
    <thead>
      <tr>
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
        <td style="padding: 0px">{{$item->code}}</td>
        <td style="padding: 0px">{{$item->product}}</td>
        <td style="padding: 0px">{{$item->description}}</td>
        <td style="padding: 0px">{{$item->unit_price}}</td>
        <td style="padding: 0px;text-align: center;">{{$item->quantity}}</td>
        <td style="padding: 0px">{{$item->weight}}</td>
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
{{-- <div style="border:1px solid grey;border-top: none;font-size: 12px; height: 16px;">
  <span style="float:left">Lines: {{count($items)}}</span>
  <span style="float:right">Price: {{$i->sum}}</span>
</div> --}}