<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hero;

class HeroController extends Controller
{
    /**
     * Show the hero settings page.
     */
    public function index()
    {
        // Get the active hero or create a default one if none exists
        $hero = Hero::where('is_active', true)->first();
        
        if (!$hero) {
            $hero = Hero::create([
                'title' => 'Discover Your Perfect Style',
                'description' => 'Explore our latest collection of premium clothing designed for comfort and style. Find your perfect fit today.',
                'is_active' => true
            ]);
        }
        
        return view('backend.hero-setting.index', compact('hero'));
    }

    /**
     * Update the hero content.
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Get the existing hero or create a new one
        $hero = Hero::where('is_active', true)->first();
        
        if (!$hero) {
            $hero = new Hero();
            $hero->is_active = true;
        }
        
        $hero->title = $request->title;
        $hero->description = $request->description;
        $hero->save();
        
        return redirect()->route('hero.index')->with('success', 'Hero content updated successfully!');
    }

    /**
     * API method to get the active hero content
     */
    public function getActiveHero()
    {
        $hero = Hero::where('is_active', true)->first();
        
        if (!$hero) {
            $hero = Hero::create([
                'title' => 'Discover Your Perfect Style',
                'description' => 'Explore our latest collection of premium clothing designed for comfort and style. Find your perfect fit today.',
                'is_active' => true
            ]);
        }
        
        return response()->json($hero);
    }
}