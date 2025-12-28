<?php

namespace App\Http\Controllers\admin;

use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index()
    {
        try {
            $clients = Client::latest()->get();
            return view('admin.clients.index', compact('clients'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the clients index page: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function view()
    {
        try {
            $brands = Client::where('status', 'a')->latest()->get();
            return view('frontend.pages.brands', compact('brands'));
        } catch (\Exception $e) {
            Log::error('Error fetching brands: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An error occurred while fetching the brands. Please try again later.');
        }
    }

    // public function create()
    // {
    //     try {
    //         $clients = Client::latest()->get();
    //         return view('admin.clients.create', compact('clients'));
    //     } catch (\Exception $e) {
    //         Log::error('Error displaying create client page: ' . $e->getMessage());
    //         return back()->with('error', 'An error occurred while trying to load the create client page. Please try again later.');
    //     }
    // }

    public function create(?Client $client = null)
    {
        try {
            $clients = Client::latest()->get();
            return view('admin.clients.create', compact('clients', 'client'));
        } catch (\Exception $e) {
            Log::error('Error displaying create client page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while trying to load the create client page. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $imagePath = 'uploads/no_images/no-image.png';

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();

                // Move the file to the correct directory
                $imageFile->move(public_path('uploads/brand'), $imageName);

                // Update the image path
                $imagePath = 'uploads/brand/' . $imageName;
            }

            Client::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('client.create')->with('success', 'Client created successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while creating client: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the client. Please try again later.');
        }
    }


    // public function edit(Client $client, $id)
    // {
    //     try {
    //         $client = Client::find($id);
    //         return view('admin.clients.edit', compact('client'));
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching client for editing: ' . $e->getMessage());
    //         return back()->with('error', 'An error occurred while fetching the client. Please try again later.');
    //     }
    // }

    public function edit($id)
    {
        try {
            $client = Client::findOrFail($id);
            $clients = Client::latest()->get();
            return view('admin.clients.create', compact('client', 'clients'));
        } catch (\Exception $e) {
            Log::error('Error fetching client for editing: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the client. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $client = Client::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Default image path (if no new image is uploaded)
            $imagePath = $client->image;

            if ($request->hasFile('image')) {
                // Check if the old image exists and delete it
                if ($client->image && file_exists(public_path('uploads/brand/' . $client->image))) {
                    unlink(public_path('uploads/brand/' . $client->image));
                }

                // Handle the uploaded image
                $imageFile = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();

                // Move the image to the correct folder
                $imageFile->move(public_path('uploads/brand'), $imageName);

                // Update the image path
                $imagePath = 'uploads/brand/' . $imageName;
            }

            $client->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
            ]);

            return redirect()->route('client.create')->with('success', 'Client updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating client: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the client. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $client = Client::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $client->status = $request->status;
            $client->save();

            return back()->with('success', 'Client status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating user status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $client = Client::findOrFail($id);

            if ($client->image && $client->image !== 'no-image.png') {
                $imagePath = public_path('uploads/brand/' . $client->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $client->delete();

            return redirect()->route('client.create')->with('success', 'Client deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting client with ID ' . $client->id . ': ' . $e->getMessage());
            return redirect()->route('client.create')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
