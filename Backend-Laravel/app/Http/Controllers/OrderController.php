<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // POST /api/orders/checkout
    public function checkout(Request $req)
    {
        $userId = $req->user()->id ?? 1;
        $cart = Cart::with('items.variant')->where('user_id',$userId)->where('status','active')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message'=>'Cart kosong'], 422);
        }

        return DB::transaction(function() use ($cart, $userId) {
            $subtotal = 0;

            // Cek stok & hitung subtotal
            foreach ($cart->items as $it) {
                if ($it->qty > $it->variant->stock) {
                    abort(422, 'Stok tidak cukup untuk varian ID '.$it->variant->id);
                }
                $subtotal += $it->qty * $it->price_at_add;
            }

            $shipping = 0;
            $discount = 0;
            $total    = $subtotal + $shipping - $discount;

            $order = Order::create([
                'user_id' => $userId,
                'status'  => 'paid', // sesuaikan dengan alur pembayaran
                'subtotal'=> $subtotal,
                'shipping_fee' => $shipping,
                'discount' => $discount,
                'total' => $total
            ]);

            // Buat order_items & kurangi stok
            foreach ($cart->items as $it) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $it->variant->product_id,
                    'product_variant_id' => $it->variant->id,
                    'qty' => $it->qty,
                    'price' => $it->price_at_add
                ]);

                // kurangi stok
                $it->variant->decrement('stock', $it->qty);
            }

            // Tandai cart selesai
            $cart->update(['status'=>'checked_out']);
            CartItem::where('cart_id',$cart->id)->delete();

            return $order->load('items.product');
        });
    }

    // GET /api/orders (riwayat order user)
    public function index(Request $req)
    {
        $userId = $req->user()->id ?? 1;
        return Order::with('items.product')
            ->where('user_id',$userId)
            ->latest()
            ->paginate(10);
    }

    // GET /api/orders/{id}
    public function show(Request $req, $id)
    {
        $userId = $req->user()->id ?? 1;
        return Order::with('items.product')
            ->where('user_id',$userId)
            ->findOrFail($id);
    }
}
