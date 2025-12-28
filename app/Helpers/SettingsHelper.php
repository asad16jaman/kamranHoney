<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class SettingsHelper
{
    public static function getSetting($key = null)
    {
        try {
            $defaultSettings = [
                'company_name' => 'Sample Company',
                'company_address' => '1234 Sample Address',
                'company_phone' => '123-456-7890',
                'hotline' => '123-000-0000',
                'company_slogan' => 'We make things better',
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
                'footer_title' => 'Quick Links',
                'footer_short_description' => 'We’re committed to delivering excellence.',
                'footer_description' => 'Full description about the company or footer info.',

                'company_about' => 'Sample Company is a leader in technology solutions.',
                'google_map' => '<iframe src="..."></iframe>',
                'office_hour' => 'Saturday to Friday: 9:00 AM - 5:00 PM',

                'copyright' => '© 2025 Sample Company',
            ];

            $setting = Setting::first();

            if (!$setting) {
                $setting = (object) $defaultSettings;
            }

            if ($key) {
                return $setting->$key ?? $defaultSettings[$key] ?? null;
            }
            return $setting;
        } catch (\Exception $e) {
            Log::error('Error retrieving website settings: ' . $e->getMessage());
            return null;
        }
    }
}
