<?php

namespace Modules\Seo\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seo\Http\Entities\Seo;
use Nwidart\Modules\Facades\Module;

class SeoController extends Controller
{

    public function __construct()
    {
//        if (Module::find('Roles')->isEnabled()) {
//            $this->middleware('permission:view seos')->only('index');
//            $this->middleware('permission:create seo')->only('create');
//            $this->middleware('permission:store seo')->only('store');
//            $this->middleware('permission:edit seo')->only('edit');
//            $this->middleware('permission:update seo')->only('update');
//            $this->middleware('permission:destroy seo')->only('destroy');
//        }
    }


    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $seo = Seo::latest()->paginate(15);

        return response()->json($seo);
    }
        /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'meta_tags'    => 'nullable|string',
            'other_codes'  => 'nullable|string',
            'page'         => 'nullable|string|max:255',
            'is_active'    => 'nullable|boolean',
        ]);

        $data['user_id'] = auth()->id();

        $seo = Seo::create($data);

        return response()->json(['message' => 'SEO created.', 'data' => $seo], 201);
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title'        => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'meta_tags'    => 'nullable|string',
            'other_codes'  => 'nullable|string',
            'page'         => 'nullable|string|max:255',
            'is_active'    => 'nullable|boolean',
        ]);

        $seo = Seo::findOrFail($id);
        $seo->update($data);

        return response()->json(['message' => 'SEO updated.', 'data' => $seo]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $seo = Seo::findOrFail($id);
        $seo->delete();

        return response()->json(['message' => 'SEO deleted.']);
    }

}
