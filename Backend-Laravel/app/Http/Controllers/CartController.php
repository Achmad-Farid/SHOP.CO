<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // GET /api/cart
    public function show(Request $req)
    {
        $userId = $req->user()->id ?? 1; // ganti sesuai auth
        $cart = Cart::firstOrCreate(['user_id'=>$userId,'status'=>'active']);

        return Cart::with('items.variant.product')
            ->find($cart->id);
    }

    // POST /api/cart/items  { variant_id, qty }
    public function addItem(Request $req)
    {
        $data = $req->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'qty'        => 'required|integer|min:1'
        ]);

        $userId = $req->user()->id ?? 1;
        $cart = Cart::firstOrCreate(['user_id'=>$userId,'status'=>'active']);

        $variant = ProductVariant::findOrFail($data['variant_id']);

        $item = CartItem::where('cart_id',$cart->id)
            ->where('product_variant_id',$variant->id)
            ->first();

        if ($item) {
            $item->qty += $data['qty'];
            $item->save();
        } else {
            $item = CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $variant->id,
                'qty' => $data['qty'],
                'price_at_add' => $variant->price
            ]);
        }

        return $item->load('variant.product');
    }

    // PUT /api/cart/items/{id}  { qty }
    public function updateItem(Request $req, $id)
    {
        $data = $req->validate([
            'qty' => 'required|integer|min:1'
        ]);
        $item = CartItem::findOrFail($id);
        $item->qty = $data['qty'];
        $item->save();
        return $item->load('variant.product');
    }

    // DELETE /api/cart/items/{id}
    public function removeItem($id)
    {
        CartItem::findOrFail($id)->delete();
        return response()->noContent();
    }

    // DELETE /api/cart/clear
    public function clear(Request $req)
    {
        $userId = $req->user()->id ?? 1;
        $cart = Cart::firstOrCreate(['user_id'=>$userId,'status'=>'active']);
        CartItem::where('cart_id',$cart->id)->delete();
        return response()->noContent();
    }
}
