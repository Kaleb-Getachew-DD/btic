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
            'hero_slides',
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

        // Hero slides (JSON + images)
        if ($request->has('hero_slides')) {
            $incoming = $request->input('hero_slides', []);
            if (!is_array($incoming)) {
                $incoming = [];
            }

            $existingRaw = Setting::get('hero_slides');
            $existing = [];
            try {
                $decoded = is_string($existingRaw) ? json_decode($existingRaw, true) : $existingRaw;
                if (is_array($decoded)) $existing = $decoded;
            } catch (\Throwable $e) {
                $existing = [];
            }

            $slides = [];
            foreach ($incoming as $index => $slide) {
                if (!is_array($slide)) continue;

                $img = $slide['img'] ?? ($existing[$index]['img'] ?? null);
                if ($request->hasFile("hero_slides_images.$index")) {
                    $file = $request->file("hero_slides_images.$index");
                    $img = $file->store('settings/hero', 'public');
                }

                $slides[] = [
                    'img' => $img,
                    'caption' => (string) ($slide['caption'] ?? ''),
                    'sub' => (string) ($slide['sub'] ?? ''),
                    'tag' => (string) ($slide['tag'] ?? ''),
                    'line1' => (string) ($slide['line1'] ?? ''),
                    'line2' => (string) ($slide['line2'] ?? ''),
                    'desc' => (string) ($slide['desc'] ?? ''),
                    'label' => (string) ($slide['label'] ?? ''),
                ];
            }

            // Remove empty slides
            $slides = array_values(array_filter($slides, function ($s) {
                return !empty($s['img']) || !empty($s['caption']) || !empty($s['label']);
            }));

            Setting::set('hero_slides', json_encode($slides));
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
