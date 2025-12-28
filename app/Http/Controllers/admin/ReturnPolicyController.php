<?php

namespace App\Http\Controllers\admin;

use App\Models\ReturnPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ReturnPolicyController extends Controller
{
    public function index()
    {
        try {
            $return = ReturnPolicy::first();
            return view('admin.return-policy.index', compact('return'));
        } catch (\Exception $e) {
            Log::error('Error fetching Return Policy content: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An error occurred while fetching the About Us content. Please try again later.');
        }
    }

    public function view()
    {
        try {
            $return = ReturnPolicy::first();
            return view('frontend.pages.return', compact('return'));
        } catch (\Exception $e) {
            Log::error('Error fetching Return Policy content: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Unable to load Return Policy at the moment.');
        }
    }


    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $return = ReturnPolicy::first();

        if (!$return) {
            return redirect()->back()->with('error', 'No record found to update.');
        }

        $return->title = $request->input('title');
        $return->description = $request->input('description');
        $return->ip_address = $request->ip();

        $return->save();

        return redirect()->route('return.index')->with('success', 'Return Policy updated successfully.');
    }
}