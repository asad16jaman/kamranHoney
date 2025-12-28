<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        try {
            $privacy = PrivacyPolicy::first();
            return view('admin.privacy-policy.index', compact('privacy'));
        } catch (\Exception $e) {
            Log::error('Error fetching Privacy Policy content: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An error occurred while fetching the About Us content. Please try again later.');
        }
    }

    public function view()
    {
        try {
            $privacy = PrivacyPolicy::first();
            return view('frontend.pages.privacy', compact('privacy'));
        } catch (\Exception $e) {
            Log::error('Error fetching Privacy Policy content: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Unable to load Privacy Policy at the moment.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $privacy = PrivacyPolicy::first();

        if (!$privacy) {
            return redirect()->back()->with('error', 'No record found to update.');
        }

        $privacy->title = $request->input('title');
        $privacy->description = $request->input('description');
        $privacy->ip_address = $request->ip();

        $privacy->save();

        return redirect()->route('privacy.index')->with('success', 'Privacy Policy updated successfully.');
    }
}