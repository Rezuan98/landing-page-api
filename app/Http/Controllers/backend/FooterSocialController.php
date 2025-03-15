<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FooterSocial;

class FooterSocialController extends Controller
{
    /**
     * Show the form for editing the footer social links.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // Get the first record or create it if it doesn't exist
        $footerSocial = FooterSocial::firstOrCreate(['id' => 1], [
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
            'twitter_url' => 'https://twitter.com',
        ]);
        
        return view('backend.footer.edit', compact('footerSocial'));
    }

    /**
     * Update the footer social links.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
        ]);

        // Get the first record
        $footerSocial = FooterSocial::firstOrCreate(['id' => 1]);
        
        // Update the record
        $footerSocial->update([
            'facebook_url' => $request->facebook_url,
            'instagram_url' => $request->instagram_url,
            'twitter_url' => $request->twitter_url,
        ]);

        return redirect()->back()->with('success', 'Footer social links updated successfully!');
    }
}