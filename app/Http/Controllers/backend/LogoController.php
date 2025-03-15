<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logo;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    /**
     * Show the logo edit form
     */
    public function edit()
    {
        $logo = Logo::first();
        return view('backend.logo.form', compact('logo'));
    }
    
    /**
     * Update the logo
     */
    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg|max:1024',
            'phone_number' => 'nullable|string|max:20',
        ]);
        
        $logo = Logo::first();
        if (!$logo) {
            $logo = new Logo();
        }
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($logo->logo) {
                Storage::disk('public')->delete($logo->logo);
            }
            
            $logoPath = $request->file('logo')->store('logos', 'public');
            $logo->logo = $logoPath;
        }
        
        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($logo->favicon) {
                Storage::disk('public')->delete($logo->favicon);
            }
            
            $faviconPath = $request->file('favicon')->store('logos', 'public');
            $logo->favicon = $faviconPath;
        }
        
        // Update phone number
        $logo->phone_number = $request->phone_number;
        
        $logo->save();
        
        return redirect()->back()->with('success', 'Logo and settings updated successfully!');
    }
}