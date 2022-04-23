<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientLmDetail as PatientLmDetailResource;
use App\Http\Resources\PatientLmDetailCollection;
use App\Http\Requests\PatientLmDetails\PatientLmDetail as PatientLmDetailRequest;
use App\Models\PatientLmDetail;

use Illuminate\Http\JsonResponse;

class PatientLmDetailController extends Controller
{
    protected $patient_lm_detail;

    public function __construct(PatientLmDetail $patient_lm_detail){
        $this->patient_lm_detail = $patient_lm_detail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            new PatientLmDetailCollection(
                $this->patient_lm_detail->orderBy('id', 'desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PatientLmDetailRequest  $request
     * @return JsonResponse
     */
    public function store(PatientLmDetailRequest $request): JsonResponse
    {
        $patientLm = $this->patient_lm_detail->create($request->all());

        return response()->json(new PatientLmDetailResource($patientLm),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PatientLmDetail $patient_lm_detail)
    {
        return response()->json(
            new PatientLmDetailResource($patient_lm_detail)
        );
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

    public function showlmdetail($id) {
        $getDetail = PatientLmDetail::where([
            'order_id' => $id
        ])->get();
        
        return response()->json(
            new PatientLmDetailCollection($getDetail)
        );
    }
}