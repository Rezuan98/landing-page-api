<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FooterSocial;

class FooterSocialApiController extends Controller
{
    /**
     * Get the footer social links
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the first record or create it if it doesn't exist
        $footerSocial = FooterSocial::firstOrCreate(['id' => 1], [
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
            'twitter_url' => 'https://twitter.com',
        ]);
        
        return response()->json([
            'status' => 'success',
            'data' => $footerSocial
        ]);
    }
}