<?php

namespace Modules\Compare\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Property\Entities\Property; // əgər məhsul "Property" modelindədirsə
use Illuminate\Support\Facades\Session;

class CompareController extends Controller
{
    public function index()
    {
        $compare = Session::get('compare', []);
        return response()->json(Property::whereIn('id', $compare)->get());
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $compare = Session::get('compare', []);

        if (!in_array($id, $compare)) {
            $compare[] = $id;
            Session::put('compare', $compare);
        }

        return response()->json(['success' => true, 'compare' => $compare]);
    }

    public function destroy($id)
    {
        $compare = Session::get('compare', []);
        $compare = array_diff($compare, [$id]);
        Session::put('compare', $compare);

        return response()->json(['success' => true, 'compare' => $compare]);
    }
}
