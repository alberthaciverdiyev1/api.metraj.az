<?php

namespace Modules\Ad\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Http\Entities\Ad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AdController extends Controller
{
    /**
     * Display a listing of ads with optional filtering.
     */
    public function list(Request $request)
    {
        try {
            $query = Ad::with('agency');

            // Agency filter
            if ($request->has('agency_id')) {
                $query->where('agency_id', $request->agency_id);
            }

            // Active filter
            if ($request->has('is_active')) {
                $query->where('is_active', $request->boolean('is_active'));
            }

            // Expired filter
            if ($request->has('expired')) {
                if ($request->boolean('expired')) {
                    $query->where('deactive_date', '<', now());
                } else {
                    $query->where('deactive_date', '>=', now());
                }
            }

            $ads = $query->latest()->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $ads
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created ad.
     */
    public function add(Request $request)
    {
        try {
            // Check if user is an agency
            $user = Auth::user();
            if (!$user || !$user->is_agency) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only agency accounts can create ads'
                ], Response::HTTP_FORBIDDEN);
            }

            $validator = Validator::make($request->all(), [
                'image' => 'required|string|max:255',
                'deactive_date' => 'required|date|after:now',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'response' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
            }

            $ad = Ad::create([
                'agency_id' => $user->id,
                'image' => $request->image,
                'deactive_date' => $request->deactive_date,
                'is_active' => false, // Default inactive, admin approves
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ad created successfully',
                'data' => $ad->load('agency')
            ], Response::HTTP_CREATED);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified ad.
     */
    public function edit(Request $request, $id)
    {
        try {
            $user = Auth::user();
            if (!$user || !$user->is_agency) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only agency accounts can edit ads'
                ], Response::HTTP_FORBIDDEN);
            }

            $ad = Ad::where('agency_id', $user->id)->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'image' => 'sometimes|string|max:255',
                'deactive_date' => 'sometimes|date|after:now',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'response' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
            }

            $ad->update($request->only(['image', 'deactive_date']));

            return response()->json([
                'success' => true,
                'message' => 'Ad updated successfully',
                'data' => $ad->load('agency')
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Change status of the ad (admin only).
     */
    public function changeStatus(Request $request, $id)
    {
        try {
            $ad = Ad::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'is_active' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'response' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
            }

            $ad->update(['is_active' => $request->boolean('is_active')]);

            return response()->json([
                'success' => true,
                'message' => 'Ad status updated successfully',
                'data' => $ad->load('agency')
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified ad from storage.
     */
    public function delete($id)
    {
        try {
            $user = Auth::user();
            
            // Check if user is owner or admin
            $ad = Ad::findOrFail($id);
            if ($user && $user->is_agency && $ad->agency_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only delete your own ads'
                ], Response::HTTP_FORBIDDEN);
            }

            $ad->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ad deleted successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get active ads for banners (public endpoint).
     */
    public function getActiveAds(Request $request)
    {
        try {
            $ads = Ad::active()->with('agency')->get();

            return response()->json([
                'success' => true,
                'data' => $ads
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
