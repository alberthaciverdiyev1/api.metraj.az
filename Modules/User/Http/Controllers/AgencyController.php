<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Transformers\UserResource;
use Modules\User\Http\Entities\User;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $agencies = User::query()
            ->where('is_agency', '=', 1)
            ->orderByDesc('is_premium')
            ->get();
        return UserResource::collection($agencies);
    }

    public function details($id)
    {
        $agency = User::query()->where('id', '=', $id)->where('is_agency', '=', 1)->first();
        return new UserResource($agency);
    }

    function makePremium(int $id)
    {
        $agency = User::query()->where('id', '=', $id)->where('is_premium', '=', 1)->first();
        return new UserResource($agency);
    }

}
