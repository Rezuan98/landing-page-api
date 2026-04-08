<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hero;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        $hero = Hero::where('is_active', true)->first();

        if (!$hero) {
            $hero = Hero::create([
                'title'       => 'Discover Your Perfect Style',
                'description' => 'Explore our latest collection of premium clothing designed for comfort and style. Find your perfect fit today.',
                'is_active'   => true,
                'hero_type'   => 'slider',
            ]);
        }

        return view('backend.hero-setting.index', compact('hero'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'hero_type'   => 'required|in:slider,video',
            'video'       => 'nullable|file|mimes:mp4,webm,ogg|max:51200',
        ]);

        $hero = Hero::where('is_active', true)->first();

        if (!$hero) {
            $hero = new Hero();
            $hero->is_active = true;
        }

        $hero->title       = $request->title;
        $hero->description = $request->description;
        $hero->hero_type   = $request->hero_type;

        if ($request->hero_type === 'video' && $request->hasFile('video')) {
            // Delete old video if exists
            if ($hero->video && Storage::disk('public')->exists($hero->video)) {
                Storage::disk('public')->delete($hero->video);
            }

            $file     = $request->file('video');
            $filename = 'hero_video_' . time() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('hero', $filename, 'public');
            $hero->video = $path;
        }

        // If switching back to slider, clear the video
        if ($request->hero_type === 'slider') {
            if ($hero->video && Storage::disk('public')->exists($hero->video)) {
                Storage::disk('public')->delete($hero->video);
            }
            $hero->video = null;
        }

        $hero->save();

        return redirect()->route('hero.index')->with('success', 'Hero settings updated successfully!');
    }

    public function getActiveHero()
    {
        $hero = Hero::where('is_active', true)->first();

        if (!$hero) {
            $hero = Hero::create([
                'title'       => 'Discover Your Perfect Style',
                'description' => 'Explore our latest collection of premium clothing designed for comfort and style. Find your perfect fit today.',
                'is_active'   => true,
                'hero_type'   => 'slider',
            ]);
        }

        return response()->json([
            'id'          => $hero->id,
            'title'       => $hero->title,
            'description' => $hero->description,
            'hero_type'   => $hero->hero_type,
            'video_url'   => $hero->video ? asset('storage/' . $hero->video) : null,
        ]);
    }
}
