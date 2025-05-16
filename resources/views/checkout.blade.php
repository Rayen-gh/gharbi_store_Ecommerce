@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4 mt-5"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Shipping and Checkout</h2>
      <div class="checkout-steps">
        <a href="#" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="#" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
        </a>
        <a href="#" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
     <form name="checkout-form" action="{{ route('order.submit') }}" method="POST">
  @csrf
  <div class="checkout-form">
    <div class="billing-info__wrapper">
      <div class="row">
        <div class="col-6">
          <h4>SHIPPING DETAILS</h4>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-md-6">
          <div class="form-floating my-3">
            <input type="text" class="form-control" name="customer_name" required>
            <label>Full Name *</label>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-floating my-3">
            <input type="email" class="form-control" name="customer_email" required>
            <label>Email Address *</label>
          </div>
        </div>

        

        <div style="margin-left: 84%" class="sticky-content">
       
        
       <button type="submit"> accept </button>
      </div>
      </div>
    </div>

   
      
    
  </div>
</form>

    </section>
  </main>
@endsection