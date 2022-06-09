<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientDiagnostic\PatientDiagnosticAdd as PatientDiagnosticRequest;
use App\Http\Requests\PatientDiagnostic\PatientDiagnosticUpdate as PatientDiagnosticUpdateRequest;
use App\Http\Resources\PatientDiagnostic as PatientDiagnosticResource;
use App\Http\Resources\PatientDiagnosticCollection;
use App\Models\PatientDiagnostic;
use Illuminate\Http\JsonResponse;

class PatientDiagnosticController extends Controller
{
    protected $patient_diagnostics;

    public function __construct(PatientDiagnostic $patient_diagnostics) {
        $this->patient_diagnostics = $patient_diagnostics;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            new PatientDiagnosticCollection(
                $this->patient_diagnostics->orderBy('id', 'desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PatientDiagnosticRequest  $request
     * @return JsonResponse
     */
    public function store(PatientDiagnosticRequest $request)
    {
        $diagnostics = $this->patient_diagnostics->create($request->all());
        return response()->json(new PatientDiagnosticResource($diagnostics), 200);
    }


    /**
     * Display the specified resource.
     *
     * @param PatientDiagnostic $patient_diagnostics
     * @return JsonResponse
     */
    public function show(PatientDiagnostic $patient_diagnostics): JsonResponse
    {
        return response()->json(
            new PatientDiagnosticResource($patient_diagnostics)
        );
    }

    public function getDiagnostics($id) {
        $patient = PatientDiagnostic::where('patient_id', $id)->get();

        return response()->json(
            new PatientDiagnosticResource($patient)
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

    public function update_diagnostic(PatientDiagnosticUpdateRequest $request, $id){
        $update_diagnostic = PatientDiagnostic::where('id', $id)
                                                ->update(['description' => $request->description]);
        return response()->json("Se actualizo correctamente el diagnostico");
    }
}
