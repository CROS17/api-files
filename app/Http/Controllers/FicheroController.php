<?php

namespace App\Http\Controllers;

use App\Http\Requests\FicheroRequest;
use App\Http\Resources\FicheroCollection;
use App\Http\Resources\FicheroResource;
use App\Models\Fichero;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FicheroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{

            $paginate = request('paginate');
            $ordercolumn = request('ordercolumn');
            $order = request('order');
            $query = request('query');
            $ficheros = Fichero::searching($query)->orderBy($ordercolumn ?? 'id', $order ?? 'ASC')->paginate($paginate ?? 5);
            return compact('ficheros');
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FicheroRequest $request)
    {
        $description = $request->file('file')->getClientOriginalDescription();
        $path = $request->file('file')->store('public/file-users');
        $fichero = new Fichero;
        $fichero->description = $description;
        $fichero->file = $path;
        $fichero->save();

        return response()->json([
            'status' => true,
            'message' => "File uploaded successfully!"
        ], Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fichero  $fichero
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Fichero $fichero)
    {
        //
//        return $fichero;
        return response()->json(
            new FicheroResource($fichero), Response::HTTP_OK
        );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fichero  $fichero
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FicheroRequest $request, Fichero $fichero)
    {
        //
        $fichero->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "File Updated successfully!"
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fichero  $fichero
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Fichero $fichero)
    {
        //
        $fichero->update([
            'status' => 0
        ]);

        return response()->json([
            'status' => true,
            'message' => "file unsubscribed successfully!",
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fichero  $fichero
     * @return \Illuminate\Http\JsonResponse
     */

    public function delete(Fichero $fichero)
    {
        //
        $record = Fichero::query()->findOrFail($fichero);
        $record->delete();

        return response()->json([
            'status' => true,
            'message' => "File Deleted successfully!",
        ], Response::HTTP_NO_CONTENT);
    }
}
