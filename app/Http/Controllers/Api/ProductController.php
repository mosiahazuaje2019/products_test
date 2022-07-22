<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\Products\Product as ProductRequest;
use App\Http\Requests\Products\ProductUpdate as ProductUpdateRequest;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new ProductCollection(
                $this->product->orderBy('name', 'asc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $request->merge(['date_boarding' => Carbon::parse($request->date_boarding)->toDateString()]);
        $product = $this->product->create($request->all());
        return response()->json(new ProductResource($product), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json(
            new ProductResource($product)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->all());
        return response()->json(new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(null, 204);
    }

    public function update_price(ProductUpdateRequest $request, $id){
        Product::where('id', $id)->update([
            'price' => $request->price,
            'name'  => $request->name
        ]);
        return response()->json("Se actualizo correctamente");
    }
}
