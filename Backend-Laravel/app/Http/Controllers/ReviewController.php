<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // GET /api/products/{productId}/reviews
    public function index($productId)
    {
        return Review::with('user')
            ->where('product_id', $productId)
            ->latest()
            ->paginate(10);
    }

    // POST /api/products/{productId}/reviews
    public function store(Request $req, $productId)
    {
        $data = $req->validate([
            'rating' => 'required|integer|min:0|max:5',
            'title'  => 'nullable|string|max:120',
            'body'   => 'nullable|string'
        ]);

        $data['product_id'] = $productId;
        $data['user_id'] = $req->user()->id ?? 1; // ganti sesuai auth (sementara default 1)

        $r = Review::create($data);

        // Optional: update cache rating di products
        $avg = Review::where('product_id',$productId)->avg('rating') ?? 0;
        $cnt = Review::where('product_id',$productId)->count();
        Product::where('id',$productId)->update([
            'rating_avg' => round($avg,2),
            'rating_count' => $cnt
        ]);

        return response()->json($r->load('user'), 201);
    }

    // DELETE /api/reviews/{id}
    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return response()->noContent();
    }
}
