<?php

namespace App\Http\Controllers\admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        try {
            $faqs = Faq::latest()->get();
            return view('admin.faqs.index', compact('faqs'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the FAQ index page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function create(?Faq $faq = null)
    {
        try {
            $faqs = Faq::latest()->get();
            return view('admin.faqs.create', compact('faqs', 'faq'));
        } catch (\Exception $e) {
            Log::error('Error displaying create FAQ page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while trying to load the create FAQ page. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        try {
            Faq::create([
                'question' => $request->question,
                'answer' => $request->answer,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('faqs.create')->with('success', 'FAQ created successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while creating FAQ: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the FAQ. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faqs = Faq::latest()->get();
            return view('admin.faqs.create', compact('faq', 'faqs'));
        } catch (\Exception $e) {
            Log::error('Error fetching FAQ for editing: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the FAQ. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $faq = Faq::findOrFail($id);

            $request->validate([
                'question' => 'required|string|max:255',
                'answer' => 'required|string',
            ]);

            $faq->update([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);

            return redirect()->route('faqs.create')->with('success', 'FAQ updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating FAQ: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the FAQ. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $faq = Faq::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $faq->status = $request->status;
            $faq->save();

            return back()->with('success', 'FAQ status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating FAQ status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();

            return redirect()->route('faqs.create')->with('success', 'FAQ deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting FAQ with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('faqs.create')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
