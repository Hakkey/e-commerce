<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/">Home</span></a>
        </li>
        
        <li class="nav-item active">
          <a class="nav-link" href="cart">Cart  <span class="badge badge-secondary"><?php echo App\Http\Controllers\CartController::getCartCount(); ?></span></span></a>
        </li>
      </ul>
    </div>
  </nav>