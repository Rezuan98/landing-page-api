<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller; // Add this line
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    // Show all sizes
    public function index()
    {
        $sizes = Size::all();
        return view('backend.size.index', compact('sizes'));
    }

    // Show create form
    public function create()
    {
        return view('backend.size.create');
    }

    // Store a new size
    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|string|unique:sizes|max:255',
        ]);

        Size::create([
            'size' => $request->size,
        ]);

        return redirect()->route('size.index')->with('info', 'Size added successfully!');
    }

    // Delete size
    public function delete($id)
    {
        Size::destroy($id);

        return redirect()->route('size.index')->with('success', 'Size deleted successfully!');
    }
}

