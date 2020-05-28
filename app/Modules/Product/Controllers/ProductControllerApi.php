<?php

namespace App\Modules\Product\Controllers;

use App\Contracts\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProduct;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Request;

class ProductControllerApi extends Controller
{
    private $products;
    public function __construct(ProductRepositoryInterface $products)
    {
        $this->products = $products;
    }

    public function saveProduct(SaveProduct $request)
    {
        $saveProduct = $this->products->save($request->all());
        if ($saveProduct) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 400]);

    }

    public function saveDownload(SaveProduct $request)
    {
        $saveProduct = $this->products->saveDownload($request->all());
        if ($saveProduct) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 400]);

    }

    public function handleSearchProducts(Request $request)
    {
        $search = [
            'keyword' => $request->query('keyword'),
        ];
        return response()->json(['status' => 200, 'products' => ProductResource::collection($this->products->search($search))]);
    }
}
