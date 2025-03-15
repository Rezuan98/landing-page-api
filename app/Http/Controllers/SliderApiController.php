<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderApiController extends Controller
{
    /**
     * Get all active sliders
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSliders()
    {
        try {
            $sliders = Slider::where('status', 1)
                ->orderBy('order')
                ->get();
                
            return response()->json($sliders);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch sliders'], 500);
        }
    }
}