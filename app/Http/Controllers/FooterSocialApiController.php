<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FooterSocial;
use Illuminate\Support\Facades\Cache;

class FooterSocialApiController extends Controller
{
    /**
     * Get the footer social links
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $footerSocial = Cache::remember('footer_social', 3600, function () {
            return FooterSocial::first();
        });

        return response()->json([
            'status' => 'success',
            'data'   => $footerSocial,
        ]);
    }
}