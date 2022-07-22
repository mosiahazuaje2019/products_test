<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presentation;

//Resources & Request
use App\Http\Resources\Presentation as PresentationResource;
use App\Http\Resources\PresentationCollection;
use App\Http\Requests\Presentation\Presentation as PresentationRequest;
use Illuminate\Http\JsonResponse;

class PresentationController extends Controller
{
    protected $presentation;

    public function __construct(Presentation $presentation) {
        $this->presentation = $presentation;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new PresentationCollection(
                $this->presentation->orderBy('name', 'asc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PresentationRequest $request
     * @return JsonResponse
     */
    public function store(PresentationRequest $request): JsonResponse
    {
        $presentation = $this->presentation->create($request->all());
        return response()->json(new PresentationResource($presentation));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
