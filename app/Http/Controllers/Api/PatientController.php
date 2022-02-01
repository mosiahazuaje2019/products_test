<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Patient as PatientResource;
use App\Http\Resources\PatientCollection;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Patients\Patient as PatientRequest;

class PatientController extends Controller
{
    protected $patient;

    public function __construct(Patient $patient) {
        $this->patient = $patient;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new PatientCollection(
                $this->patient->orderBy('id', 'asc')->get()
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
}
