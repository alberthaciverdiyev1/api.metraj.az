<?php

namespace Modules\Media\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Media\Http\Services\MediaService;
use Nwidart\Modules\Facades\Module;

class MediaController extends Controller
{

    public function __construct()
    {
//        if (Module::find('Roles')->isEnabled()) {
//            $this->middleware('permission:view medias')->only('index');
//            $this->middleware('permission:create media')->only('create');
//            $this->middleware('permission:store media')->only('store');
//            $this->middleware('permission:edit media')->only('edit');
//            $this->middleware('permission:update media')->only('update');
//            $this->middleware('permission:destroy media')->only('destroy');
//        }
    }


    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        return view('media::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('media::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required|string|in:image,video,document',
                'path' => 'required|url|max:500',
                'imageable_type' => 'required|string',
                'imageable_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->errors()
                ], 422);
            }

            $media = MediaService::storeFromUrl(
                $request->type,
                $request->path,
                $request->imageable_type,
                $request->imageable_id
            );

            return response()->json([
                'status' => 200,
                'message' => 'Media created successfully',
                'data' => $media
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show()
    {
        return view('media::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('media::edit');
    }

    /**
     * Upload media via URL (instead of file upload)
     */
    public function uploadUrl(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required|string|in:image,video,document',
                'url' => 'required|url|max:500',
                'imageable_type' => 'required|string',
                'imageable_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->errors()
                ], 422);
            }

            $media = MediaService::storeFromUrl(
                $request->type,
                $request->url,
                $request->imageable_type,
                $request->imageable_id
            );

            return response()->json([
                'status' => 200,
                'message' => 'Media uploaded successfully',
                'data' => $media
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {

            //TODO:UPDATE FUNCTIONS

            return response()->json(__('Data successfully updated!'));
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        try {

            //TODO:DESTROY FUNCTIONS

            return response()->json(__('Data successfully deleted!'));
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
