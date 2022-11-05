<?php

namespace App\Http\Controllers;

use App\Http\Requests\FicheroRequest;
use App\Http\Resources\FicheroCollection;
use App\Http\Resources\FicheroResource;
use App\Models\Activitylog;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FicheroController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
        $this->storeLog();

    }

    /** List Media **/
    public function index()
    {
        try {

            $paginate = request('paginate');
            $ordercolumn = request('ordercolumn');
            $order = request('order');
            $query = request('query');

            $ficheros = Media::searching($query)->orderBy($ordercolumn ?? 'id', $order ?? 'ASC')->paginate($paginate ?? 5);

            return FicheroCollection::make($ficheros);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        }


    }

    /** register media **/
    public function store(FicheroRequest $request)
    {

        try {

            $files = $request->validated()['files'];

            foreach ($files as $file) {
                $path = $file->store('public/file-users');
                Media::create([
                    'url' => $path
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => "File uploaded successfully!"
            ], Response::HTTP_CREATED);


        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /** show one media **/
    public function show(Media $fichero)
    {
        return FicheroResource::make($fichero);
    }

    /** update media **/
    public function update(FicheroRequest $request, Media $fichero)
    {


        try {

            if($fichero->url){
                Storage::delete($fichero->url);
            }

            $path = $request->file('url')->store('public/file-users');
            $fichero->update([
                'file' => $path
            ]);

            return response()->json([
                'status' => true,
                'message' => "File Updated successfully!"
            ], Response::HTTP_OK);


        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /** delete logica media **/
    public function delete(Media $fichero)
    {

        $fichero = Media::query()->findOrFail($fichero->id);
        $fichero->delete();

        return response()->json([
            'status' => true,
            'message' => "file Deleted successfully!",
        ], Response::HTTP_NO_CONTENT);
    }

    /** destroy fisica media **/
    public function destroy(Media $fichero)
    {

        DB::table('media')->delete($fichero->id);

        return response()->json([
            'status' => true,
            'message' => "File Destroy successfully!",
        ], Response::HTTP_NO_CONTENT);
    }

    public function storeLog()
    {
       $log = Activitylog::query()->firstOrNew(['user_id' => 1]);//auth()->id()]);
       $log->total = $log->total + 1;
       $log->save();
    }

}
