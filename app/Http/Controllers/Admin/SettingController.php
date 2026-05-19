<?php
// FILE: app/Http/Controllers/Admin/SettingController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $fields = [
            'site_name', 'site_tagline', 'site_description', 'contact_email',
            'contact_phone', 'contact_address', 'facebook_url', 'twitter_url',
            'linkedin_url', 'youtube_url', 'hero_title', 'hero_subtitle',
            'about_short', 'mission_statement', 'vision_statement',
            'stats_startups', 'stats_cohorts', 'stats_jobs', 'stats_funding',
            'footer_text', 'google_analytics_id',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field));
            }
        }

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $old = Setting::get('site_logo');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('site_logo')->store('settings', 'public');
            Setting::set('site_logo', $path);
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $path = $request->file('site_favicon')->store('settings', 'public');
            Setting::set('site_favicon', $path);
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
