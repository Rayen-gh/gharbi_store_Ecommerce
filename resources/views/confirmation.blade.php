@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4 mt-5"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Order Received</h2>
      <div class="checkout-steps">
        <!-- Deleting routes mel checkout w confir w cart w tbdlhom ki tvalidi l order-->
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
        <a href="#" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
      <div class="order-complete">
    <div class="order-complete__message">
        {{-- Keep the existing SVG --}}
        <h3>Your order is completed!</h3>
        <p>Thank you. Your order has been received.</p>
    </div>
    
    <div class="order-info">
        <div class="order-info__item">
            <label>Order ID</label>
            <span>#{{ $order->id }}</span>
        </div>
        <div class="order-info__item">
            <label>Date</label>
            <span>{{ $order->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="order-info__item">
            <label>Total</label>
            <span>{{ ($order->grand_total) }}</span>
        </div>
    </div>

    <div class="checkout__totals-wrapper">
        <div class="checkout__totals">
            <h3>Order Details</h3>
            <table class="checkout-cart-items">
                <thead>
                    <tr>
                        <th>PRODUCT</th>
                        <th>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->id }} x {{ $item->quantity }}
                        </td>
                        <td>
                            {{ ($item->price * $item->quantity) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <table class="checkout-totals">
                <tbody>
                    <tr>
                        <th>SUBTOTAL</th>
                        <td>{{ ($order->subtotal) }}</td>
                    </tr>
                    <tr>
                        <th>TOTAL</th>
                        <td>{{ ($order->grand_total) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
    </section>
  </main>

@endsection