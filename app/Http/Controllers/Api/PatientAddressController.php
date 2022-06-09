<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientAddress as PatientAddressResource;
use App\Http\Resources\PatientAddressCollection;
use App\Http\Requests\PatientAddress\PatientAddressAdd as PatientAddressRequest;
use App\Models\PatientAdress;

class PatientAddressController extends Controller
{
    protected $patient;

    public function __construct(PatientAdress $patient){
        $this->patient = $patient;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            new PatientAddressCollection(
                $this->patient->orderBy('id', 'desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PatientAddressRequest  $request
     * @return JsonResponse
     */
    public function store(PatientAddressRequest $request)
    {
        $patient = $this->patient->create($request->all());
        return response()->json(new PatientAddressResource($patient), 200);
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

    public function getAddress($id, $category){
        $patient = PatientAdress::where('patient_id',$id)
                                 ->where('category', $category)
                                 ->get();
        return response()->json($patient);
    }

}
