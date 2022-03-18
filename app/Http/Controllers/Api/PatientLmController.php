<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\PatientLm as PatientLmResource;
use App\Http\Resources\PatientLmCollection;
use App\Models\PatientLm;
use Illuminate\Http\Response;
use App\Http\Requests\Patients\PatientLmRequest;
use Carbon\Carbon;

class PatientLmController extends Controller
{
    protected $patient_lm;

    public function __construct(PatientLm $patient_lm){
        $this->patient_lm = $patient_lm;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new PatientLmCollection(
                $this->patient_lm->orderBy('id','desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(PatientLmRequest $request)
    {
        $request->merge(['date_ini' => Carbon::parse($request->date_ini)->toDateString()]);
        $request->merge(['date_end' => Carbon::parse($request->date_end)->toDateString()]);
        $request->merge(['doctor_id' =>  $request->doctor_id['id']]);

        $patient_lm = $this->patient_lm->create($request->all());
        return response()->json(new PatientLmResource($patient_lm), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
