<?php

namespace Modules\Setting\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Http\Requests\SettingRequest;
use Modules\Setting\Http\Transformers\SettingResource;
use Nwidart\Modules\Facades\Module;
use Modules\Setting\Http\Entities\Setting;

class SettingController extends Controller
{

    public function __construct()
    {
//        if (Module::find('Roles')->isEnabled()) {
//            $this->middleware('permission:view settings')->only('index');
//            $this->middleware('permission:create setting')->only('create');
//            $this->middleware('permission:store setting')->only('store');
//            $this->middleware('permission:edit setting')->only('edit');
//            $this->middleware('permission:update setting')->only('update');
//            $this->middleware('permission:destroy setting')->only('destroy');
//        }
    }


    /**
     * Display a listing of the resource.
     */
    public function getData()
    {
        return SettingResource::make(Setting::query()->first());
    }

    public function setData(SettingRequest $request)
    {
        try {
            $validated = $request->validated();
            $setting = Setting::query()->first();
            $setting->update($validated);
            return response()->json(__('Setting successfully updated!'));
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

}
