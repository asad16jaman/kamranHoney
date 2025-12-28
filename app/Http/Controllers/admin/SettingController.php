<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function setting()
    {
        try {
            $setting = Setting::firstOrNew([], [
                'company_name' => 'Sample Company',
                'company_address' => '1234 Sample Address',
                'company_phone' => '123-456-7890',
                'hotline' => '123-456-7890',
                'company_slogan' => '',
                'company_email' => 'info@samplecompany.com',
                'facebook_url' => '',
                'twitter_url' => '',
                'linkedin_url' => '',
                'instagram_url' => '',
                'inside' => 0,
                'outside' => 0,
                'favicon_image' => '',
                'company_logo' => '',
                'footer_logo' => '',
                'footer_title' => '',
                'footer_short_description' => '',
                'footer_description' => '',
                'company_about' => 'Sample Company is a leader in technology solutions.',
                'google_map' => '',
                'office_hour' => 'Saturday to Friday: 9:00 AM - 5:00 PM',
                'copyright' => '© 2025 Sample Company',
            ]);

            return view('admin.settings.general_setting', compact('setting'));
        } catch (\Exception $e) {
            Log::error('Error occurred while retrieving or processing the settings: ' . $e->getMessage());
            return redirect()
                ->route('dashboard')
                ->with('error', 'An unexpected error occurred while loading the settings. Please try again later.');
        }
    }


    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_phone' => 'required|string|max:20',
            'hotline' => 'nullable|string|max:20',
            'company_slogan' => 'nullable|string|max:100',
            'company_email' => 'required|email|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'inside' => 'nullable|numeric|min:0',
            'outside' => 'nullable|numeric|min:0',
            'favicon_image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'company_logo' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'footer_logo' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'footer_title' => 'nullable|string|max:255',
            'footer_short_description' => 'nullable|string|max:1000',
            'footer_description' => 'nullable|string|max:1000',
            'company_about' => 'required|string',
            'google_map' => 'nullable|string',
            'office_hour' => 'nullable|string',
            'copyright' => 'required|string|max:255',
        ]);

        try {
            $setting = Setting::first();
            if (!$setting) {
                $setting = new Setting();
            }

            // Handle favicon image upload
            if ($request->hasFile('favicon_image')) {
                if ($setting->favicon_image && file_exists(public_path('uploads/logo_and_icon/' . $setting->favicon_image))) {
                    unlink(public_path('uploads/logo_and_icon/' . $setting->favicon_image));
                }
                $faviconImage = $request->file('favicon_image');
                $faviconName = now()->format('Ymd') . rand(1000, 9999) . '.' . $faviconImage->getClientOriginalExtension();
                $faviconImage->move(public_path('uploads/logo_and_icon'), $faviconName);
                $setting->favicon_image = $faviconName;
            }

            // Handle company logo upload
            if ($request->hasFile('company_logo')) {
                if ($setting->company_logo && file_exists(public_path('uploads/logo_and_icon/' . $setting->company_logo))) {
                    unlink(public_path('uploads/logo_and_icon/' . $setting->company_logo));
                }
                $logoImage = $request->file('company_logo');
                $logoName = now()->format('Ymd') . rand(1000, 9999) . '.' . $logoImage->getClientOriginalExtension();
                $logoImage->move(public_path('uploads/logo_and_icon'), $logoName);
                $setting->company_logo = $logoName;
            }

            // Handle footer logo upload
            if ($request->hasFile('footer_logo')) {
                if ($setting->footer_logo && file_exists(public_path('uploads/logo_and_icon/' . $setting->footer_logo))) {
                    unlink(public_path('uploads/logo_and_icon/' . $setting->footer_logo));
                }
                $footerLogoImage = $request->file('footer_logo');
                $footerLogoName = now()->format('Ymd') . rand(1000, 9999) . '.' . $footerLogoImage->getClientOriginalExtension();
                $footerLogoImage->move(public_path('uploads/logo_and_icon'), $footerLogoName);
                $setting->footer_logo = $footerLogoName;
            }

            // Update other fields
            $setting->company_name = $request->company_name;
            $setting->company_address = $request->company_address;
            $setting->company_phone = $request->company_phone;
            $setting->hotline = $request->hotline;
            $setting->company_slogan = $request->company_slogan;
            $setting->company_email = $request->company_email;
            $setting->facebook_url = $request->facebook_url;
            $setting->twitter_url = $request->twitter_url;
            $setting->linkedin_url = $request->linkedin_url;
            $setting->instagram_url = $request->instagram_url;
            $setting->inside = $request->inside;
            $setting->outside = $request->outside;
            $setting->footer_title = $request->footer_title;
            $setting->footer_short_description = $request->footer_short_description;
            $setting->footer_description = $request->footer_description;
            $setting->company_about = strip_tags($request->company_about);
            $setting->google_map = $request->google_map;
            $setting->office_hour = $request->office_hour;
            $setting->copyright = $request->copyright;

            $setting->save();

            return redirect()->back()->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating settings: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update settings. Please try again later.');
        }
    }
}
