<?php

namespace App\Http\Controllers\admin;

use App\Models\AboutUs;
use App\Models\Counter;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AboutUsController extends Controller
{
    public function index()
    {
        try {
            $aboutUs = AboutUs::first();
            return view('admin.about-us.index', compact('aboutUs'));
        } catch (\Exception $e) {
            Log::error('Error fetching About Us content: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'An error occurred while fetching the About Us content. Please try again later.');
        }
    }

    public function view()
    {
        try {
            $aboutUs = AboutUs::first();
            return view('frontend.pages.about-us', compact('aboutUs'));
        } catch (\Exception $e) {
            Log::error('Error fetching about us content: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An error occurred while fetching the about us content. Please try again later.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        $aboutUs = AboutUs::first();

        if (!$aboutUs) {
            return redirect()->back()->with('error', 'No record found to update.');
        }

        $aboutUs->title = $request->input('title');
        $aboutUs->button_text = $request->input('button_text');
        $aboutUs->description = strip_tags($request->input('description'));
        $aboutUs->ip_address = $request->ip();

        if ($request->hasFile('image_path')) {
            if ($aboutUs->image_path && file_exists(public_path('uploads/about/' . $aboutUs->image_path))) {
                unlink(public_path('uploads/about/' . $aboutUs->image_path));
            }

            $image = $request->file('image_path');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/about'), $imageName);

            $aboutUs->image_path = $imageName;
        }

        $aboutUs->save();

        return redirect()->route('about-us.index')->with('success', 'About Us updated successfully.');
    }
}
