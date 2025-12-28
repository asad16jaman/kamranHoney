<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.pages.login');
    }

    public function showRegisterForm()
    {
        return view('frontend.pages.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->remember)) {
            return redirect()->route('customer.dashboard')->with('success', 'Logged in successfully.');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:customers,email',
            'phone'           => 'required|string|max:20',
            'password'        => 'required|string|min:6|confirmed',
            'image'           => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'address_line_1'  => 'nullable|string|max:255',
            'address_line_2'  => 'nullable|string|max:255',
            'city'            => 'required|string|max:100',
            'zip_code'        => 'required|string|max:10',
        ]);

        try {

            $imagePath = 'uploads/no_images/no-image.png';

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads/customers'), $imageName);
                $imagePath = 'uploads/customers/' . $imageName;
            }

            $customer = Customer::create([
                'first_name'      => $request->first_name,
                'last_name'       => $request->last_name,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'password'        => Hash::make($request->password),
                'image'           => $imagePath,
                'address_line_1'  => $request->address_line_1,
                'address_line_2'  => $request->address_line_2,
                'city'            => $request->city,
                'zip_code'        => $request->zip_code,
            ]);

            Auth::guard('customer')->login($customer);

            return redirect()->route('customer.dashboard')->with('success', 'Registered and logged in!');
        } catch (\Exception $e) {
            Log::error('Customer registration failed: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during registration. Please try again.');
        }
    }

    public function profile()
    {
        $customer = auth('customer')->user();
        return view('frontend.pages.profile', compact('customer'));
    }

    public function dashboard()
    {
        $customer = auth('customer')->user();

        $orderCount = Order::where('customer_id', $customer->id)->count();
        $pendingCount = Order::where('customer_id', $customer->id)->where('status', 'p')->count();
        $approvedCount = Order::where('customer_id', $customer->id)->where('status', 'a')->count();
        $canceledCount = Order::where('customer_id', $customer->id)->where('status', 'd')->count();

        $latestOrder = Order::where('customer_id', $customer->id)->latest()->first();

        return view('frontend.pages.dashboard', compact('customer', 'orderCount', 'pendingCount', 'approvedCount', 'canceledCount', 'latestOrder'));
    }

    public function updateProfile(Request $request)
    {
        $id = auth('customer')->id();
        $customer = Customer::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'phone'           => 'required|string|max:20',
            'address_line_1'  => 'nullable|string|max:255',
            'address_line_2'  => 'nullable|string|max:255',
            'city'            => 'required|string|max:100',
            'zip_code'        => 'required|string|max:10',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Image handling like register()
            if ($request->hasFile('image')) {
                // Delete old image if it's not the default one
                if (!empty($customer->image) && $customer->image !== 'uploads/no_images/no-image.png' && file_exists(public_path($customer->image))) {
                    @unlink(public_path($customer->image));
                }

                $imageFile = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads/customers'), $imageName);
                $customer->image = 'uploads/customers/' . $imageName;
            }

            // Update other fields
            $customer->first_name     = $request->first_name;
            $customer->last_name      = $request->last_name;
            $customer->phone          = $request->phone;
            $customer->address_line_1 = $request->address_line_1;
            $customer->address_line_2 = $request->address_line_2;
            $customer->city           = $request->city;
            $customer->zip_code       = $request->zip_code;

            $customer->save();

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Customer profile update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        $id = auth('customer')->id();
        $customer = Customer::findOrFail($id);

        if (!Hash::check($request->current_password, $customer->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        try {
            $customer->update([
                'password' => Hash::make($request->new_password),
            ]);

            return back()->with('success', 'Password changed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to change password. Please try again.');
        }
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('home')->with('success', 'Logged out.');
    }
}
