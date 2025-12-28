<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\TermsConditions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class TermsConditionController extends Controller
{
    public function index()
    {
        try {
            $term = TermsConditions::first();
            return view('admin.terms-conditions.index', compact('term'));
        } catch (\Exception $e) {
            Log::error('Error fetching Terms & Conditions: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An error occurred while fetching the About Us content. Please try again later.');
        }
    }

    public function view()
    {
        try {
            $term = TermsConditions::first();
            return view('frontend.pages.terms', compact('term'));
        } catch (\Exception $e) {
            Log::error('Error fetching Terms & Conditions content: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Unable to load Terms & Conditions at the moment.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $term = TermsConditions::first();

        if (!$term) {
            return redirect()->back()->with('error', 'No record found to update.');
        }

        $term->title = $request->input('title');
        $term->description = $request->input('description');
        $term->ip_address = $request->ip();

        $term->save();

        return redirect()->route('terms.index')->with('success', 'Terms & Conditions updated successfully.');
    }
}