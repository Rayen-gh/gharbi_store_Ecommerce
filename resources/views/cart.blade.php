@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4 mt-5"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Cart</h2>
      <div class="checkout-steps">
        <a href="{{route('cart.index')}}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="{{route('cart.checkout')}}" class="checkout-steps__item">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
        </a>
        <a href="{{ isset($order) ? route('order.confirmation', $order->id) : '#' }}" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
      <div class="shopping-cart">
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th></th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
    @if(session()->has('cart') && count(session('cart')) > 0)
        @foreach (session('cart') as $id => $details)
        <tr>
            <td>
                <div class="shopping-cart__product-item">
                    <img loading="lazy" src="{{ asset('uploads/products/' . $details['image']) }}" width="120" height="120" alt="" />
                </div>
            </td>
            <td>
                <div class="shopping-cart__product-item__detail">
                    <h4>{{ $details['name'] }}</h4>
                </div>
            </td>
            <td>
                <span class="shopping-cart__product-price">${{ $details['price'] }}</span>
            </td>
            <td>
                <div class="qty-control position-relative">
    <input type="number" name="quantity" data-id="{{ $id }}" value="{{ $details['quantity'] }}" min="1" class="qty-control__number text-center">
    <div class="custom-qty-reduce">-</div>
    <div class="custom-qty-increase">+</div>
</div>

<style>
.custom-qty-increase, 
.custom-qty-reduce {
    position: absolute;
    right: 10px;
    width: 20px;
    height: 20px;
    cursor: pointer;
    user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    background: #f5f5f5;
    border-radius: 2px;
    transition: all 0.3s ease;
}

.custom-qty-reduce {
    bottom: 5px;
}

.custom-qty-increase {
    top: 5px;
}

.custom-qty-increase:hover,
.custom-qty-reduce:hover {
    background: #e0e0e0;
}
</style>
            </td>
            <td>
                <span class="shopping-cart__subtotal">${{ $details['price'] * $details['quantity'] }}</span>
            </td>
            <td>
              <form action="{{route('cart.remove')}}" method="post">
                <a href="" type="submit"   class="remove-cart" data-id="{{ $id }}">
    <svg width="10"  height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
        <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
        <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
    </svg>
</a>
</form>
            </td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">Your cart is empty.</td>
        </tr>
    @endif
</tbody>

          </table>
          <div class="cart-table-footer">
            <form action="#" class="position-relative bg-body">
              <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
              <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                value="APPLY COUPON">
            </form>
            <div class="btn btn-light">
                <a href="{{route('cart.checkout')}}" class="">PROCEED TO CHECKOUT</a>
              </div>
            
          </div>
        </div>
        <div class="shopping-cart__totals-wrapper">
          <div class="sticky-content">
            <div class="shopping-cart__totals">
              <h3>Cart Totals</h3>
              <table class="cart-totals">
    @if(session()->has('cart') && count(session('cart')) > 0)
        <tbody>
            @php
                $total = 0;
            @endphp
            
            @foreach (session('cart') as $id => $details)
                <tr>
                    <th>{{ $details['quantity'] }} - {{ $details['name'] }}</th>
                    <td>${{ number_format($details['price'], 2) }}</td>
                </tr>
                @php
                    $total += $details['price'] * $details['quantity'];
                @endphp
            @endforeach
            
            <tr>
                <th>Total</th>
                <td>${{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    @else
        <tbody>
            <tr>
                <th>Your cart is empty</th>
                <td></td>
            </tr>
            <tr>
                <th>Total</th>
                <td>$0.00</td>
            </tr>
        </tbody>
    @endif
</table>
            </div>
            <div class="mobile_fixed-btn_wrapper">
              
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    // Quantity Controls
    $('.custom-qty-increase').on('click', function() {
        const input = $(this).siblings('.qty-control__number');
        let quantity = parseInt(input.val()) || 1;
        input.val(quantity + 1).trigger('change');
    });

    $('.custom-qty-reduce').on('click', function() {
        const input = $(this).siblings('.qty-control__number');
        let quantity = parseInt(input.val()) || 2;
        if (quantity > 1) {
            input.val(quantity - 1).trigger('change');
        }
    });

    // Handle quantity changes
    $('.qty-control__number').on('change', function() {
        const input = $(this);
        const productId = input.data('id');
        const quantity = parseInt(input.val()) || 1;
        const price = parseFloat(input.closest('tr').find('.shopping-cart__product-price').text().replace('$', ''));
        
        // Update subtotal
        const subtotal = price * quantity;
        input.closest('tr').find('.shopping-cart__subtotal').text('$' + subtotal.toFixed(2));
        
        // Update cart via AJAX
        $.ajax({
            url: '/update-cart',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: productId,
                quantity: quantity
            },
            success: function(response) {
                recalculateCart();
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                alert('Error updating cart');
            }
        });
    });

    // Remove item
    $('.remove-cart').on('click', function(e) {
        e.preventDefault();
        const productId = $(this).data('id');
        const row = $(this).closest('tr');
        
        $.ajax({
            url: '/remove-from-cart',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: productId
            },
            success: function(response) {
                row.remove();
                recalculateCart();
                if ($('.cart-table tbody tr').length === 0) {
                    location.reload();
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                alert('Error removing item');
            }
        });
    });

    // Cart calculations
    function recalculateCart() {
        let total = 0;
        
        $('.cart-table tbody tr').each(function() {
            const subtotal = parseFloat($(this).find('.shopping-cart__subtotal').text().replace('$', ''));
            total += subtotal;
        });
        
        $('.cart-totals tr:last-child td').text('$' + total.toFixed(2));
        updateCartTotalsItems();
    }

    function updateCartTotalsItems() {
        $('.cart-totals tbody tr:not(:last-child)').remove();
        let itemsHtml = '';
        
        $('.cart-table tbody tr').each(function() {
            const name = $(this).find('.shopping-cart__product-item__detail h4').text();
            const quantity = $(this).find('.qty-control__number').val();
            const subtotal = $(this).find('.shopping-cart__subtotal').text();
            
            itemsHtml += `
                <tr>
                    <th>${quantity} × ${name}</th>
                    <td>${subtotal}</td>
                </tr>
            `;
        });
        
        $('.cart-totals tbody').prepend(itemsHtml);
    }
});
</script>
@endpush