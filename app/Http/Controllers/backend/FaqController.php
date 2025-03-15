<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the faqs.
     */
    public function index()
    {
        $faqs = Faq::ordered()->get();
        return view('backend.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new faq.
     */
    public function create()
    {
        return view('backend.faq.create');
    }

    /**
     * Store a newly created faq in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'status' => 'required|boolean',
        ]);

        // Get the highest order value
        $maxOrder = Faq::max('order') ?? 0;
        
        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('faq.index')->with('success', 'FAQ added successfully!');
    }

    /**
     * Show the form for editing the specified faq.
     */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('backend.faq.edit', compact('faq'));
    }

    /**
     * Update the specified faq in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
        ]);

        return redirect()->route('faq.index')->with('success', 'FAQ updated successfully!');
    }

    /**
     * Remove the specified faq from storage.
     */
    public function delete($id)
    {
        Faq::destroy($id);
        return redirect()->route('faq.index')->with('success', 'FAQ deleted successfully!');
    }
    
    /**
     * Update the order of FAQs
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);
        
        $ids = $request->ids;
        
        foreach ($ids as $index => $id) {
            Faq::where('id', $id)->update(['order' => $index + 1]);
        }
        
        return response()->json(['success' => true]);
    }
    
    /**
     * API endpoint to get active FAQs for frontend
     */
    public function getActiveFaqs()
    {
        $faqs = Faq::active()->ordered()->get();
        return response()->json(['faqs' => $faqs]);
    }
}