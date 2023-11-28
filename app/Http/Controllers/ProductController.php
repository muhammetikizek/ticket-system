<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        public ProductService $productService,
        public ProductRepository $productRepository
    )
    {
    }

    public function index()
    {
        return view('product.index', [
            'products' => [],
        ]);
    }

    public function getProducts(Request $request)
    {
        $products = $this->productRepository->getProducts($request->categoryId);
        return response()->json([
            'data' => $products,
        ], 200);
    }
}
