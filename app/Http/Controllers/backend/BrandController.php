<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('backend.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('backend.brand.create');
    }
public function store(Request $request)


    {  
         
        // $request->validate([
        //     'name' => 'required|string|unique:brands|max:255',
        // ]);

        $brand = new Brand();
        $brand->name = $request->brand;
        $brand->save();
        return redirect()->route('brand.index')->with('success', 'Brand added successfully!');
    }

    public function delete($id)
    {
        Brand::destroy($id);

        return redirect()->route('brand.index')->with('success', 'Brand deleted successfully!');
    }
}
