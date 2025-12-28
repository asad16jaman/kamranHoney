<?php

namespace App\Http\Controllers\admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function index()
    {
        try {
            $coupons = Coupon::latest()->get();
            return view('admin.coupons.index', compact('coupons'));
        } catch (\Exception $e) {
            Log::error('Error loading coupon index page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function create(?Coupon $coupon = null)
    {
        try {
            $coupons = Coupon::latest()->get();
            return view('admin.coupons.create', compact('coupon', 'coupons'));
        } catch (\Exception $e) {
            Log::error('Error loading coupon create page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'code'                  => 'required|string|unique:coupons,code|max:100',
            'type'                  => 'required|in:fixed,percent',
            'value'                 => 'required|numeric|min:0',
            'usage_limit'           => 'nullable|integer|min:0',
            'usage_limit_per_user'  => 'nullable|integer|min:0',
            'start_date'            => 'nullable|date',
            'end_date'              => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            Coupon::create([
                'code'                 => strtoupper($request->input('code')),
                'type'                 => $request->input('type'),
                'value'                => $request->input('value'),
                'usage_limit'          => $request->input('usage_limit'),
                'usage_limit_per_user' => $request->input('usage_limit_per_user'),
                'start_date'           => $request->input('start_date'),
                'end_date'             => $request->input('end_date'),
            ]);

            DB::commit();
            return back()->with('success', 'Coupon created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating coupon: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the coupon.');
        }
    }

    public function edit($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupons = Coupon::latest()->get();

            return view('admin.coupons.create', compact('coupon', 'coupons'));
        } catch (\Exception $e) {
            Log::error('Error loading coupon edit page: ' . $e->getMessage());
            return redirect()->route('coupons.create')->with('error', 'An unexpected error occurred.');
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $request->validate([
            'code'                  => 'required|string|max:100|unique:coupons,code,' . $id,
            'type'                  => 'required|in:fixed,percent',
            'value'                 => 'required|numeric|min:0',
            'usage_limit'           => 'nullable|integer|min:0',
            'usage_limit_per_user'  => 'nullable|integer|min:0',
            'start_date'            => 'nullable|date',
            'end_date'              => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            $coupon = Coupon::findOrFail($id);

            $coupon->update([
                'code'                 => strtoupper($request->input('code')),
                'type'                 => $request->input('type'),
                'value'                => $request->input('value'),
                'usage_limit'          => $request->input('usage_limit'),
                'usage_limit_per_user' => $request->input('usage_limit_per_user'),
                'start_date'           => $request->input('start_date'),
                'end_date'             => $request->input('end_date'),
            ]);

            DB::commit();
            return redirect()->route('coupons.create')->with('success', 'Coupon updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating coupon: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the coupon.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $coupon->status = $request->status;
            $coupon->save();

            return back()->with('success', 'Coupon status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating coupon status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status.');
        }
    }

    public function destroy($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();

            return back()->with('success', 'Coupon deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting coupon with ID ' . $id . ': ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
