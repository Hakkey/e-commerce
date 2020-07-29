@extends('layouts.app')
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
@section('content')
  <div class="row">
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
          <tr class="rowKey" key="{{ $orderItem->item_id }}"  reference-no="{{ $order->reference_no }}" order-id="{{ $order->id }}">
            <td>{{ $orderItem->product_name }}</td>
            <td class="test" >{{ $orderItem->cost_per_item }}</td>
            <td item-quantity="{{ $orderItem->quantity }}">
              <button class="btn btn-sm btn-danger btnDecrease">-</button>
              <input type="text" class=" inputQuantity" style="width: 20%;" value="{{ $orderItem->quantity }}">
              <button class="btn btn-sm btn-success btnIncrease" >+</button>
            </td>
            <td class="totalItem">{{ $orderItem->quantity * $orderItem->cost_per_item  }}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="3">Subtotal</td>
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
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col text-center">
      <a class="btn btn-danger text-white" id="btnCancel">
        Cancel
      </a>
      <div class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
        Checkout
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <p>Total Paid Amount</p>
            </div>
            <div class="col">
              <input type="text" id="modal-paid" class="form-control">
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <p>Total</p>
            </div>
            <div class="col text-center">
              <p id='modal-total'></p>
            </div>
          </div>
          <div class="row">
            <div class="col">
              Payment Method
            </div>
            <div class="col">
              <select name="" id="modal-payment" class="form-control">
                <option value="Cash" selected>Cash</option>
              </select>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <p>Change</p>
            </div>
            <div class="col text-center">
              <p id="modal-change"></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btnSubmit">Submit</button>
        </div>
      </div>
    </div>
  </div>
@endsection

<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
  $(document).ready(function(){
    $('#subTotal').text(calc_subtotal());
    $('#noItems').text(calc_quantity());
    $('#tax').text(calc_tax().toFixed(2));
    $('#allTotal').text(calc_allTotal().toFixed(2));
    $('#modal-total').text(calc_allTotal().toFixed(2));

    $('.btnDecrease').on('click', function(){
      var quantity = parseInt($(this).parent('td').find('input').val());
      var price = parseFloat($(this).parents('tr').find('td.test').text());
      var id = $(this).parents('tr').attr('key');
      var order_id = $('.rowKey').attr('order-id');

      quantity = quantity - 1;


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
            order_id:order_id,
          },
          success: function(result) {
            // alert('ok');
          },
          error: function(result) {
            alert('');
          }
        });
        $(this).parents('tr').remove();

        location.reload();
        
      }

      var calc = quantity * price;

      $(this).parent('td').find('input').val(quantity);
      $(this).parents('tr').find('td.totalItem').text(calc);

      $('#subTotal').text(calc_subtotal());
      $('#noItems').text(calc_quantity());
      $('#tax').text(calc_tax().toFixed(2));
      $('#allTotal').text(calc_allTotal().toFixed(2));
      $('#modal-total').text(calc_allTotal().toFixed(2));

      var paid = $('#modal-paid').val();
      $('#modal-change').text(calc_change(paid).toFixed(2));


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

      $('#subTotal').text(calc_subtotal());
      $('#noItems').text(calc_quantity());
      $('#tax').text(calc_tax().toFixed(2));
      $('#allTotal').text(calc_allTotal().toFixed(2));
      $('#modal-total').text(calc_allTotal().toFixed(2));

      var paid = $('#modal-paid').val();
      $('#modal-change').text(calc_change(paid).toFixed(2));

    });

    $('#modal-paid').on('keyup', function(){
      var paid = $(this).val();

      $('#modal-change').text(calc_change(paid).toFixed(2));
    })

    $('#btnSubmit').on('click', function(){
    
      var order_id = $('.rowKey').attr('order-id');
      var reference_no = $('.rowKey').attr('reference-no');
      var tax = $('#tax').text();
      var total_amount_cents = $('#modal-total').text();
      var order_status = 'Completed';
      var transaction_status = 'Paid';
      var payment_method = $('#modal-payment option:selected').text();
      var paid_amount_cents = $('#modal-paid').val();

      $.ajax({
        type: "POST",
        url: "storeorder/"+ reference_no,
        data: {
          "_token": "{{ csrf_token() }}",
          order_id: order_id,
          reference_no: reference_no,
          tax: tax,
          total_amount_cents: total_amount_cents,
          order_status: order_status,
          transaction_status: transaction_status,
          payment_method:payment_method,
          paid_amount_cents:paid_amount_cents,
        },
        success: function(result) {
          Swal.fire({
            title: 'Done',
            text: "Payment is successful.",
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok!'
          }).then((result) => {
            if (result.value) {
              window.location.href = '/summaryorder/' + order_id;
            }
          })
        },
        error: function(result) {
          alert('error');
        }
      });
    })

    $('#btnCancel').on('click', function(){

      var order_id = $('.rowKey').attr('order-id');

      $.ajax({
        type: "DELETE",
        url: "/neworder/"+ order_id,
        data: {
          "_token": "{{ csrf_token() }}",
          order_id: order_id,
        },
        success: function(result) {
          Swal.fire({
            title: 'Done',
            text: "Your cart has been emptied.",
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok!'
          }).then((result) => {
            if (result.value) {
              window.location.href = '/';
            }
          })
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
        sum += parseFloat($(this).val());
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