<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class SliderController extends Controller
{
    public function index()
    {
        try {
            $sliders = Slider::latest()->get();
            return view('admin.sliders.index', compact('sliders'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the sliders index page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function create(?Slider $slider = null)
    {
        try {
            $sliders = Slider::latest()->get();
            return view('admin.sliders.create', compact('sliders', 'slider'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the slider create page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'slider_image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'slider_title_one' => 'nullable|string|max:255',
            'slider_title_two' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
        ]);

        try {

            $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' .
                ($request->file('slider_image')
                    ? $request->file('slider_image')->getClientOriginalExtension()
                    : '');

            // Define image path
            $imagePath = 'uploads/sliders/' . $imageName;

            if ($request->hasFile('slider_image')) {

                // Move uploaded file to the specified directory
                $request->file('slider_image')->move(public_path('uploads/sliders'), $imageName);
            } else {
                $imagePath = 'uploads/no_images/no-image.png';
            }

            Slider::create([
                'slider_image' => $imageName,
                'slider_title_one' => $request->input('slider_title_one'),
                'slider_title_two' => $request->input('slider_title_two'),
                'description' => strip_tags($request->input('description')),
                'button_text' => $request->input('button_text'),
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            return back()->with('success', 'Slider created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occurred while creating the slider: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the slider. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $sliders = Slider::latest()->get();
            return view('admin.sliders.create', compact('slider', 'sliders'));
        } catch (\Exception $e) {
            Log::error('Error occurred while retrieving the slider for editing: ' . $e->getMessage());
            return redirect()->route('sliders.create')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $request->validate([
            'slider_image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'slider_title_one' => 'nullable|string|max:255',
            'slider_title_two' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
        ]);

        try {

            $slider = Slider::findOrFail($id);

            $imageName = $slider->slider_image;

            if ($request->hasFile('slider_image')) {

                $newImageName = now()->format('Ymd') . rand(1000, 9999) . '.' .
                    $request->file('slider_image')->getClientOriginalExtension();

                // Define the new image path
                $newImagePath = 'uploads/sliders/' . $newImageName;

                // Move the new image to the specified directory
                $request->file('slider_image')->move(public_path('uploads/sliders'), $newImageName);

                // Unlink the old image if it's not the default placeholder
                if ($slider->slider_image && $slider->slider_image !== 'no-image.png') {
                    $oldImagePath = public_path('uploads/sliders/' . $slider->slider_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $imageName = $newImageName;
            }

            $slider->update([
                'slider_image' => $imageName,
                'slider_title_one' => $request->input('slider_title_one'),
                'slider_title_two' => $request->input('slider_title_two'),
                'description' => strip_tags($request->input('description')),
                'button_text' => $request->input('button_text'),
            ]);

            DB::commit();

            return redirect()->route('sliders.create')->with('success', 'Slider updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occurred while updating the slider: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the slider. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $slider = Slider::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $slider->status = $request->status;
            $slider->save();

            return back()->with('success', 'Slider status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating user status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {

            $slider = Slider::findOrFail($id);

            // Unlink the image file if it's not the default placeholder
            if ($slider->slider_image && $slider->slider_image !== 'no-image.png') {
                $imagePath = public_path('uploads/sliders/' . $slider->slider_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $slider->delete();

            return redirect()->back()->with('success', 'Slider deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting slider with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
