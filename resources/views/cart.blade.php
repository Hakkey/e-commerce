@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col">
      <table class="table table-borderless">
        <thead>
          <tr>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Cost</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orderItems as $orderItem)
          <tr key="{{ $orderItem->item_id }}">
            <td>{{ $orderItem->product_name }}</td>
            <td class="test" >{{ $orderItem->cost_per_item }}</td>
            <td item-quantity="{{ $orderItem->quantity }}">
              <button class="btn btn-sm btn-danger btnDecrease">-</button>
              <input type="text" value="{{ $orderItem->quantity }}">
              <button class="btn btn-sm btn-success btnIncrease" >+</button>
            </td>
            <td class="totalItem">{{ $orderItem->quantity * $orderItem->cost_per_item  }}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="3">Subtotal</td>
            <td id="subTotal"></td>
          </tr>
          <tr>
            <td colspan="3">No. of Items</td>
            <td id="noItems"></td>
          </tr>
          <tr>
            <td colspan="3">Tax</td>
            <td id="tax"></td>
          </tr>
          <tr style="border-top: 1px solid">
            <td colspan="3">Total</td>
            <td id="allTotal"></td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
@endsection

<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>

<script>
  $(document).ready(function(){
    // $('td').on('click', function(){
    //   var quantity = parseInt($(this).attr('item-quantity'));
    //   // alert(quantity);
    // });

    $('#subTotal').text(calc_total());
    $('#noItems').text(calc_quantity());
    $('#tax').text(calc_total());
    $('#allTotal').text(calc_allTotal());

    $('.btnDecrease').on('click', function(){
      var quantity = parseInt($(this).parent('td').find('input').val());
      var price = parseFloat($(this).parents('tr').find('td.test').text());

      quantity = quantity - 1;

      var id = $(this).parents('tr').attr('key');

      $.ajax({
        type: "POST",
        url: "updatequantity/"+ id,
        data: {
          "_token": "{{ csrf_token() }}",
          id: id,
          quantity: quantity,
        }
      });

      if(quantity == 0)
      {
        $.ajax({
          type: "DELETE",
          url: "removeorder/"+ id,
          data: {
            "_token": "{{ csrf_token() }}",
            id: id,
          },
          success: function(result) {
            alert('ok');
          },
          error: function(result) {
            alert('error');
          }
        });
        $(this).parents('tr').remove();

        location.reload();
        
      }

      var calc = quantity * price;

      $(this).parent('td').find('input').val(quantity);
      $(this).parents('tr').find('td.totalItem').text(calc);

      calc_total();
      calc_quantity()

    });

    $('.btnIncrease').on('click', function(){
      var quantity = parseInt($(this).parent('td').find('input').val());
      var price = parseFloat($(this).parents('tr').find('td.test').text());

      quantity = quantity + 1;

      var id = $(this).parents('tr').attr('key');
      // console.log(id);

      $.ajax({
        type: "POST",
        url: "updatequantity/"+ id,
        data: {
          "_token": "{{ csrf_token() }}",
          id: id,
          quantity: quantity,
        }
      });

      var calc = quantity * price;

      // console.log(quantity);

      $(this).parent('td').find('input').val(quantity);
      $(this).parents('tr').find('td.totalItem').text(calc);

      calc_total();
      calc_quantity()

    });

    function calc_total(){
      var sum = 0;
      $(".totalItem").each(function(){
        sum += parseFloat($(this).text());
      });
      $('#subTotal').text(sum);
    }

    function calc_quantity(){
      var sum = 0;
      $("input").each(function(){
        sum += parseFloat($(this).val());
      });
      $('#noItems').text(sum);
    }

    function calc_allTotal(){
      var sum = 0;
      $(".totalItem").each(function(){
        sum += parseFloat($(this).text());
      });

      sum = parseFloat(1.06 * sum) ;
      $('#allTotal').text(sum.toFixed(2));
    }

  });

  
</script>