<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\MainController as MainController;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductServices;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::all();
        return $this->successResponse($products, 'Product list viewed Successfully', Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreProductRequest $request
     * @param ProductServices $productServices
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request, ProductServices $productServices)
    {
        $image = $productServices->image($request);
        $data['product'] = Product::create(array_merge($request->all(), $image));
        return $this->successResponse($data, 'Product Created Successfully', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return $this->successResponse($product, 'Product Viewed Successfully', Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateProductRequest $request
     * @param \App\Models\Product $product
     * @param ProductServices $productServices
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product, ProductServices $productServices)
    {
        $image = $productServices->image($request);
        $product->update(array_merge($request->all(), $image));
        $data['product'] =  $product;
        return $this->successResponse($data, 'Product Updated Successfully', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @param ProductServices $productServices
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product, ProductServices $productServices)
    {
        $productServices->imageDelete($product->image);
        $product->delete();
        return $this->successResponse('Deleted', 'Product Deleted Successfully', Response::HTTP_OK);
    }

    public function filterProduct(Request $request, Product $product)
    {
        $filter = $product->newQuery();
        if ($request->has('name')) {
            $filter->where('name', 'LIKE', "%{$request->name}%");
        }
        return $this->successResponse($filter->get(), 'Product filtered Successfully', Response::HTTP_OK);
    }

}
