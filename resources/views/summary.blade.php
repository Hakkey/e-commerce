@extends('layouts.app')
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
@section('content')
  <div class="row mb-4">
    <div class="col">
      <table class="table table-borderless">
        <thead>
          <tr class="table-primary">
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Cost (RM)</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orderItems as $orderItem)
          <tr class="rowKey" key="{{ $orderItem->order_id }}" >
            <td>{{ $orderItem->product_name }}</td>
            <td class="test" >{{ $orderItem->cost_per_item }}</td>
            <td item-quantity="{{ $orderItem->quantity }}">
              <p class="inputQuantity">{{ $orderItem->quantity }} </p>
            </td>
            <td class="totalItem">{{ $orderItem->quantity * $orderItem->cost_per_item  }}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="3">order</td>
            <td id="subTotal">RM</td>
          </tr>
          <tr>
            <td colspan="3">No. of Items</td>
            <td id="noItems"></td>
          </tr>
          <tr>
            <td colspan="3">Tax (6%)</td>
            <td id="tax"></td>
          </tr>
          <tr class="table-primary" style="border-top: 1px solid">
            <td colspan="3">Total</td>
            <td id="allTotal"></td>
          </tr>
          <tr>
            <td colspan="3">Total paid</td>
            <td>{{ $transaction->paid_amount_cents }}</td>
          </tr>
          
          <tr class="table-primary">
            <td colspan="3">Status</td>
            <td>{{ $transaction->status }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="btn btn-secondary" id="newOrder">
        New Order
      </div>
        
    </div>
  </div>
@endsection

<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>

<script>
  $(document).ready(function(){
    $('#subTotal').text(calc_subtotal());
    $('#noItems').text(calc_quantity());
    $('#tax').text(calc_tax().toFixed(2));
    $('#allTotal').text(calc_allTotal().toFixed(2));
    $('#modal-total').text(calc_allTotal().toFixed(2));

    $('#newOrder').on('click', function(){

      var order_id = $('.rowKey').attr('key');

      console.log(order_id);

        $.ajax({
        type: "DELETE",
        url: "/neworder/"+ order_id,
        data: {
          "_token": "{{ csrf_token() }}",
          order_id: order_id,
        },
        success: function(result) {
          window.location.href = '/';
        },
        error: function(result) {
          alert('error');
        }
      });
    })

    function calc_subtotal(){
      var sum = 0;
      $(".totalItem").each(function(){
        sum += parseFloat($(this).text());
      });
      // $('#subTotal').text(sum);

      return sum;
    }

    function calc_quantity(){
      var sum = 0;
      $(".inputQuantity").each(function(){
        sum += parseFloat($(this).text());
      });
      return sum;
    }

    function calc_tax(){
      var sum = 0;
      var tax = 0;
      $(".totalItem").each(function(){
        sum += parseFloat($(this).text());
      });

      tax = parseFloat(0.06 * calc_subtotal());

      return tax;
    }

    function calc_allTotal(){
      var sum = 0;
      $(".totalItem").each(function(){
        sum += parseFloat($(this).text());
      });

      sum = parseFloat(1.06 * sum) ;

      return sum;
    }

    function calc_change(paid){
      var change = parseFloat(paid - calc_allTotal());

      return change;
    }
  });
</script>