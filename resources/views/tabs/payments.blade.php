<div class="row" style="margin-top: 10px">
  <div class="col-md-12">
    <p>There are no payments recorded for this invoice. <button style="float: right">-</button><button style="float: right;" onclick="addPayment()">+</button></p>
    <table class="table table-bordered table-custom">
      <thead>
        <tr>
          <th style="padding: 0px;">Payment Id</th>
          <th style="padding: 0px">Payment date</th>
          <th style="padding: 0px">Paid by</th>
          <th style="padding: 0px">Description</th>
          <th style="padding: 0px">Amount</th>
        </tr>
      </thead>
      <tbody>
        @foreach($payments as $p)
        <tr>
          <td style="padding: 0px">{{$p->id}}</td>
          <td style="padding: 0px">{{$p->payment_date}}</td>
          <td style="padding: 0px">{{$p->paid_by}}</td>
          <td style="padding: 0px">{{$p->description}}</td>
          <td style="padding: 0px">{{$p->amount}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>