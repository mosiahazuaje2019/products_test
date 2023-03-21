<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
    }

    public function fileStore(Request $request) {
        $upload_path = public_path('upload');
        $file_name = $request->file->getClientOriginalName();
        $generated_new_name = time().'.'.$request->file->getClientOriginalExtension();
        //$request->file->move($upload_path, $generated_new_name);
        $disk = Storage::disk('gcs');
        $content = "";
        $url = $disk->put('documents/'.$request->patient_id.'/'.$generated_new_name, $content);
        
        $insert['title'] = $file_name;
        Photo::create([
            'title'      => $insert['title'],
            'patient_id' => $request->patient_id,
            'uri'        => 'documents/'.$request->patient_id.'/'.$generated_new_name
        ]);
        return response()->json(['success' => 'You have a succesefully uploaded "'. $file_name. '"']); 
    }
}
