<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logo;

class SettingController extends Controller
{
    /**
     * Get site settings for frontend
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSettings()
    {
        try {
            $logo = Logo::first();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'logo' => $logo ? $logo->logo : null,
                    'favicon' => $logo ? $logo->favicon : null,
                    'phone_number' => $logo ? $logo->phone_number : null,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}