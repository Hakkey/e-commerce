
@extends('layouts.app')

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
@section('content')
{{-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Shop</li>
    </ol>
</nav> --}}
  <div class="row">
    <div class="col">
      <h4 class="text-center">Products In Our Store</h4>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-md-3 col-sm-12 d-flex justify-content-center mb-2">
      <div class="card h-100 shadow" item-id="1">
        <img class="card-img-top" height="170px" src="{{ asset('images/house.jpg') }}" alt="Card image cap">
        <div class="card-body">
        <h5 class="card-title mt-auto" item-name="House">House</h5>
        RM<span item-price="18.00"> 18.00</span>
        <button class="btn btn-primary btn-block mt-2">Add to cart</button>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-12 d-flex justify-content-center mb-2">
      <div class="card h-100 shadow" item-id="2">
        <img class="card-img-top" height="170px" src="{{ asset('images/stars.jpg') }}" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title mt-auto" item-name="Stars">Stars</h5>
          RM<span item-price="10.50"> 10.50</span>
          <button class="btn btn-primary btn-block mt-2">Add to cart</button>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-12 d-flex justify-content-center mb-2">
      <div class="card h-100 shadow" item-id="3">
        <img class="card-img-top" height="170px" src="{{ asset('images/trees.jpg') }}" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title mt-auto" item-name="Trees">Trees</h5>
          RM<span item-price="7.00"> 7.00</span>
          <button class="btn btn-primary btn-block mt-2">Add to cart</button>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-12 d-flex justify-content-center mb-2">
      <div class="card h-100 shadow" item-id="4">
        <img class="card-img-top" height="170px" src="{{ asset('images/island.jpg') }}" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title" item-name="Island">Island</h5>
          RM<span class="pricey" item-price="90.00"> 90.00</span>
          <button class="btn btn-primary btn-block mt-2">Add to cart</button>
        </div>
      </div>
    </div>
  </div>
@endsection

<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
<script>
  $( document ).ready(function() {
    $(".card").on('click', function(event){

      var id = $(this).attr('item-id');
      var name = $(this).find('h5').attr('item-name');
      var price = $(this).find('span').attr('item-price');

      $.ajax({
        type: "POST",
        url: "storecart/"+ id,
        data: {
          "_token": "{{ csrf_token() }}",
          id: id,
          name: name,
          price: price,
        },
        success: function(result) {
          Swal.fire({
            title: 'Done',
            text: "Item has been added to cart.",
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok!'
          }).then((result) => {
            if (result.value) {
              location.reload();
            }
          })
        },
        error: function(result) {
          alert('error');
        }
      });
    });
  });
</script>