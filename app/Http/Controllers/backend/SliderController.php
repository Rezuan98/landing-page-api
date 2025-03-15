<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('backend.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('backend.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean',
            'order' => 'nullable|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            if ($request->hasFile('image')) {
                // Get the uploaded file
                $image = $request->file('image');
                
                // Generate a unique filename
                $filename = 'slider_' . time() . '.' . $image->getClientOriginalExtension();
                
                // Store the image in the public disk under the sliders directory
                $path = $image->storeAs('sliders', $filename, 'public');
                
                // Create the slider record
                Slider::create([
                    'image' => $path,
                    'status' => $request->status,
                    'order' => $request->order ?? 0,
                ]);
                
                return redirect()->route('slider.index')->with('success', 'Slider image added successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error uploading image: ' . $e->getMessage())->withInput();
        }
        
        return redirect()->back()->with('error', 'No image was uploaded.')->withInput();
    }

    public function delete($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            
            // Delete the image file
            if (Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            
            // Delete the record
            $slider->delete();
            
            return redirect()->route('slider.index')->with('success', 'Slider deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('slider.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}