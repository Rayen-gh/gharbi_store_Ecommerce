<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function submitOrder(Request $request)
{
    // Step 1: Validate customer data
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255'
        
    ]);

    // Step 2: Get cart from session
    $cart = session()->get('cart');

    if (!$cart || count($cart) == 0) {
        return redirect()->back()->with('error', 'Cart is empty.');
    }

    // Step 3: Create Order
    $order = Order::create([
        'customer_name' => $request->customer_name,
        'customer_email' => $request->customer_email,

    ]);

      //Step 4: Create OrderItems
    foreach ($cart as $productId => $item) {
        OrderItem::create([
            'order_id' => $order->id,
         'product_id' => $productId,
           'quantity' => $item['quantity'],
'price' => $item['price'],
      ]);
    }



    // Step 5: Clear session cart
    session()->forget('cart');

    return redirect()->route('order.confirmation', ['id' => $order->id])
        ->with('success', 'Order placed successfully!');
}

public function confirmation($orderId)
{
    $order = Order::with('items.product')->findOrFail($orderId);
    return view('confirmation', compact('order'));
}

 public function show(Order $order)
    {
        // Add authorization check
        $this->authorize('view', $order);

        return view('orders.show', [
            'order' => $order->load('items.product')
        ]);
    }
}
