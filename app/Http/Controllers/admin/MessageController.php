<?php

namespace App\Http\Controllers\admin;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index()
    {
        try {
            $message = Message::first();
            return view('admin.message.index', compact('message'));
        } catch (\Exception $e) {
            Log::error('Error fetching Message content: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An error occurred while fetching the Message content. Please try again later.');
        }
    }

    public function view()
    {
        try {
            $message = Message::first();
            return view('frontend.pages.message', compact('message'));
        } catch (\Exception $e) {
            Log::error('Error fetching message: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An error occurred while fetching the message. Please try again later.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name_2' => 'nullable|string|max:255',
            'designation_2' => 'nullable|string|max:255',
            'message_2' => 'nullable|string|max:1000',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $message = Message::first();

        if (!$message) {
            return redirect()->back()->with('error', 'No record found to update.');
        }

        $message->name = $request->input('name');
        $message->designation = $request->input('designation');
        $message->message = strip_tags($request->input('message'));
        $message->name_2 = $request->input('name_2');
        $message->designation_2 = $request->input('designation_2');
        $message->message_2 = strip_tags($request->input('message_2'));
        $message->ip_address = $request->ip();

        if ($request->hasFile('image')) {
            if ($message->image && file_exists(public_path('uploads/message/' . $message->image))) {
                unlink(public_path('uploads/message/' . $message->image));
            }

            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/message'), $imageName);

            $message->image = $imageName;
        }

        if ($request->hasFile('image_2')) {
            if ($message->image_2 && file_exists(public_path('uploads/message/' . $message->image_2))) {
                unlink(public_path('uploads/message/' . $message->image_2));
            }

            $image2 = $request->file('image_2');
            $imageName2 = uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('uploads/message'), $imageName2);
            $message->image_2 = $imageName2;
        }

        $message->save();

        return redirect()->route('message.index')->with('success', 'Message updated successfully.');
    }
}
