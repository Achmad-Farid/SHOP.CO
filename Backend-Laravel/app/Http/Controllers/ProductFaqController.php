<?php

namespace App\Http\Controllers;

use App\Models\ProductFaq;
use Illuminate\Http\Request;

class ProductFaqController extends Controller
{
    // GET /api/products/{productId}/faqs
    public function index($productId)
    {
        return ProductFaq::where('product_id',$productId)
            ->whereIn('status',['answered','pending'])
            ->latest()
            ->paginate(10);
    }

    // POST /api/products/{productId}/faqs  (user bertanya)
    public function store(Request $req, $productId)
    {
        $data = $req->validate([
            'question' => 'required|string|max:2000'
        ]);

        $faq = ProductFaq::create([
            'product_id' => $productId,
            'user_id'    => $req->user()->id ?? null,
            'question'   => $data['question'],
            'status'     => 'pending'
        ]);

        return response()->json($faq, 201);
    }

    // PUT /api/faqs/{id}/answer  (admin menjawab)
    public function answer(Request $req, $id)
    {
        $data = $req->validate([
            'answer' => 'required|string'
        ]);

        $faq = ProductFaq::findOrFail($id);
        $faq->answer = $data['answer'];
        $faq->answered_by = $req->user()->id ?? null; // isi admin id jika ada auth
        $faq->status = 'answered';
        $faq->save();

        return $faq;
    }

    // DELETE /api/faqs/{id}
    public function destroy($id)
    {
        ProductFaq::findOrFail($id)->delete();
        return response()->noContent();
    }
}
