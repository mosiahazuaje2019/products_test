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
use App\Http\Requests\Patients\PatientLmUpdate;

use App\Exports\OrderExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

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
    public function update(PatientLmUpdate $request, PatientLm $patient_lm)
    {
        $patient_lm->update($request->all());
        return response()->json(new PatientLmResource($patient_lm));
    }

    /**
     * Update order the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update_order(PatientLmUpdate $request, $id)
    {
        $patient_lm = PatientLm::where('id', $id)->update([
            'lm_code' => $request->lm_code,
            'authorized_by' => $request->authorized_by,
            'observation'   => $request->observation
        ]);
        return response()->json("Se a guardado satisfactoriamente!");
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

    public function export() {
        return Excel::download(new OrderExport, 'orders.xlsx');
    }

    //Metodo para encontrar ordenes de pacientes o pacientes
    public function findOrders($id) {
        $find_orders = DB::table('patient_lms')
                        ->join('patients', 'patient_lms.patient_id','=','patients.id')
                        ->select('*')
                        ->where('patient_lms.lm_code',$id)
                        ->orWhere('patients.personal_id',$id)
                        ->orWhere('patients.first_name','like',$id.'%')
                        ->orWhere('patients.last_name','like',$id.'%')
                        ->get();
        return response()->json($find_orders);
    }
}
