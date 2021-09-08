<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\Brand as BrandResource;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Brands\Brand as BrandRequest;

class BrandController extends Controller
{
    protected $brand;

    public function __construct(Brand $brand) {
        $this->brand = $brand;
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new BrandCollection(
                $this->brand->orderBy('id', 'desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandRequest $request
     * @return JsonResponse
     */
    public function store(BrandRequest $request): JsonResponse
    {
        $brand = $this->brand->create($request->all());

        return response()->json(new BrandResource($brand), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Brand $brands
     * @return JsonResponse
     */
    public function show(Brand $brand): JsonResponse
    {
        return response()->json(
            new BrandResource($brand)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BrandRequest $request
     * @param Brand $brand
     * @return JsonResponse
     */
    public function update(BrandRequest $request, Brand $brand): JsonResponse
    {
        $brand->update($request->all());
        return response()->json(new BrandResource($brand));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return JsonResponse
     */
    public function destroy(Brand $brand): JsonResponse
    {
        $brand->delete();
        return response()->json(null, 204);
    }
}
