<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logo;
use Illuminate\Support\Facades\Cache;

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
            $data = Cache::remember('site_settings', 3600, function () {
                $logo = Logo::first();
                return [
                    'logo'         => $logo ? $logo->logo : null,
                    'favicon'      => $logo ? $logo->favicon : null,
                    'phone_number' => $logo ? $logo->phone_number : null,
                ];
            });

            return response()->json([
                'success' => true,
                'data'    => $data,
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