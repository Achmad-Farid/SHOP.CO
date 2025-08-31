<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // GET /api/products
    // Query params: category_slug, q, color_id, size_id, min_price, max_price, sort (latest|bestseller|price_asc|price_desc|rating)
    public function index(Request $req)
    {
        $categorySlug = $req->query('category_slug');
        $q            = $req->query('q');
        $colorId      = $req->query('color_id');
        $sizeId       = $req->query('size_id');
        $min          = $req->integer('min_price') ?? 0;
        $max          = $req->integer('max_price') ?? PHP_INT_MAX;
        $sort         = $req->query('sort', 'latest');

        $query = Product::query()->where('status','active');

        if ($categorySlug) {
            $query->whereHas('category', fn($qq) => $qq->where('slug', $categorySlug));
        }

        if ($q) {
            $query->where(function($qq) use ($q){
                $qq->where('name','like',"%$q%")
                   ->orWhere('short_description','like',"%$q%");
            });
        }

        // Filter via variants existence
        $query->whereHas('variants', function($v) use($colorId,$sizeId,$min,$max){
            $v->whereBetween('price', [$min, $max])
              ->when($colorId, fn($vv)=>$vv->where('color_id',$colorId))
              ->when($sizeId,  fn($vv)=>$vv->where('size_id',$sizeId))
              ->where('stock','>',0);
        });

        // Sorting
        if ($sort === 'price_asc') {
            $query->orderBy(DB::raw('COALESCE(min_variant_price, base_price)'), 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy(DB::raw('COALESCE(min_variant_price, base_price)'), 'desc');
        } elseif ($sort === 'rating') {
            $query->orderBy('rating_avg','desc')->orderBy('rating_count','desc');
        } elseif ($sort === 'bestseller') {
            // join order_items to get SUM(qty)
            $query->leftJoin('order_items','order_items.product_id','=','products.id')
                  ->leftJoin('orders', function($join){
                      $join->on('orders.id','=','order_items.order_id')
                           ->whereIn('orders.status',['paid','shipped','completed']);
                  })
                  ->select('products.*', DB::raw('COALESCE(SUM(order_items.qty),0) as sold_qty'))
                  ->groupBy('products.id')
                  ->orderBy('sold_qty','desc')
                  ->orderBy('products.created_at','desc');
        } else {
            // latest (default)
            $query->latest();
        }

        // include images + minimal variants for card view
        $query->with(['images','variants' => function($v){
            $v->orderBy('price','asc')->limit(3);
        }]);

        return $query->paginate(20);
    }

    // GET /api/products/latest
    public function latest()
    {
        return Product::where('status','active')
            ->with('images')
            ->latest()
            ->limit(20)
            ->get();
    }

    // GET /api/products/bestseller
    public function bestseller()
    {
        return Product::where('status','active')
            ->leftJoin('order_items','order_items.product_id','=','products.id')
            ->leftJoin('orders', function($join){
                $join->on('orders.id','=','order_items.order_id')
                     ->whereIn('orders.status',['paid','shipped','completed']);
            })
            ->select('products.*', DB::raw('COALESCE(SUM(order_items.qty),0) as sold_qty'))
            ->groupBy('products.id')
            ->orderBy('sold_qty','desc')
            ->with('images')
            ->limit(20)
            ->get();
    }

    // GET /api/products/{id}
    public function show($id)
    {
        return Product::with([
                'images',
                'variants.color',
                'variants.size',
                'reviews.user',
                'faqs'
            ])->findOrFail($id);
    }

    // GET /api/products/slug/{slug}
    public function showBySlug($slug)
    {
        return Product::with([
            'images',
            'variants.color',
            'variants.size',
            'reviews.user',
            'faqs'
        ])->where('slug',$slug)->firstOrFail();
    }

    // POST /api/products   (opsional untuk admin)
    public function store(Request $req)
    {
        $data = $req->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name'        => 'required|string|max:160',
            'slug'        => 'nullable|string|max:180',
            'short_description' => 'nullable|string|max:300',
            'description' => 'nullable|string',
            'base_price'  => 'required|integer|min:0',
            'compare_at_price' => 'nullable|integer|min:0',
            'status'      => 'in:draft,active,archived',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']).'-'.substr(uniqid(),-4);
        }

        $p = Product::create($data);
        return response()->json($p, 201);
    }

    // PUT /api/products/{id}  (opsional admin)
    public function update(Request $req, $id)
    {
        $p = Product::findOrFail($id);

        $data = $req->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name'        => 'sometimes|string|max:160',
            'slug'        => 'sometimes|string|max:180|unique:products,slug,'.$p->id,
            'short_description' => 'nullable|string|max:300',
            'description' => 'nullable|string',
            'base_price'  => 'sometimes|integer|min:0',
            'compare_at_price' => 'nullable|integer|min:0',
            'status'      => 'in:draft,active,archived',
        ]);

        $p->update($data);
        return $p->fresh();
    }

    // DELETE /api/products/{id} (opsional admin)
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->noContent();
    }
}
