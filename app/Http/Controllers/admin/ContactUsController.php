<?php

namespace App\Http\Controllers\admin;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Rules\ReCaptcha;

class ContactUsController extends Controller
{
    public function index()
    {
        try {
            $contactUs = ContactUs::latest()->get();
            return view('admin.contact-us.index', compact('contactUs'));
        } catch (\Exception $e) {
            Log::error('Error fetching Contact Us content: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the Contact Us content. Please try again later.');
        }
    }

    public function create()
    {
        try {
            return view('frontend.pages.contact-us');
        } catch (\Exception $e) {
            Log::error('Error opening Create Contact Us form: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while opening the Create Contact Us form. Please try again later.');
        }
    }

    public function contactSubmit(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'nullable|string|max:255',
                'message' => 'nullable|string|max:500',
                'phone' => 'nullable|string|max:20',
                'g-recaptcha-response' => [new ReCaptcha()],
            ]);

            $contact = ContactUs::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'phone' => $request->phone,
                'ip_address' => $request->ip(),
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Your message has been sent successfully!']);
            }

            return back()->with('success', 'Your message has been sent successfully!');
        } catch (\Illuminate\Validation\ValidationException $validationException) {

            Log::error('Validation failed for contact form.', [
                'errors' => $validationException->errors(),
                'input' => $request->all()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validationException->errors(),
                    'message' => 'Validation failed.'
                ], 422);
            }

            return back()->withErrors($validationException->errors());
        } catch (\Exception $e) {

            Log::error('Contact form submission failed.', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Something went wrong.'], 500);
            }

            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }


    public function destroy($id)
    {
        try {

            $contact = ContactUs::findOrFail($id);

            // dd($contact->all());

            if ($contact->attachment && file_exists(public_path('admin/files/' . $contact->attachment))) {
                unlink(public_path('admin/files/' . $contact->attachment));
            }

            $contact->delete();

            return redirect()->route('contact-us.index')->with('success', 'Contact Us inquiry deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting Contact Us entry: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the Contact Us entry. Please try again later.');
        }
    }
}
