<?php

namespace App\Http\Controllers;

use App\Http\Requests\FicheroRequest;
use App\Http\Resources\FicheroCollection;
use App\Http\Resources\FicheroResource;
use App\Models\Fichero;
use Illuminate\Http\Request;

class FicheroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ficheros = Fichero::all();
        return new FicheroCollection(
            $ficheros->paginate(
                env('FILES_PER_PAGE', request('per_page'))
            )
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FicheroRequest $request)
    {

        $fichero = new Fichero($request->all());
        if ($request->hasFile('file')) {
            $path = $request->file->store('public/file-users');
        }

        $fichero->file = 'file-users/' . basename($path);
        $fichero->save();

        return response()->json([
            'status' => true,
            'message' => "File uploaded successfully!"
        ], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fichero  $fichero
     * @return \Illuminate\Http\Response
     */
    public function show(Fichero $fichero)
    {
        //
//        return $fichero;
        return response()->json(
            new FicheroResource($fichero), 200
        );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fichero  $fichero
     * @return \Illuminate\Http\Response
     */
    public function update(FicheroRequest $request, Fichero $fichero)
    {
        //
        $fichero->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "File Updated successfully!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fichero  $fichero
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fichero $fichero)
    {
        //
        $fichero->update([
            'status' => 0
        ]);

        return response()->json([
            'status' => true,
            'message' => "File Deleted successfully!",
        ], 204);
    }
}
