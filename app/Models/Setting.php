<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group', 'label'];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value): void
    {
        $setting = static::where('key', $key)->first();

        if ($setting) {
            $setting->update(['value' => $value]);
        } else {
            static::create(array_merge(static::metaForKey($key), [
                'key' => $key,
                'value' => $value,
            ]));
        }

        Cache::forget('setting_' . $key);
    }

    public static function getGroup(string $group): array
    {
        return static::where('group', $group)->pluck('value', 'key')->toArray();
    }

    protected static function metaForKey(string $key): array
    {
        $labels = [
            'site_name' => 'Site Name',
            'site_tagline' => 'Site Tagline',
            'site_description' => 'Site Description',
            'site_logo' => 'Site Logo',
            'site_favicon' => 'Site Favicon',
            'contact_email' => 'Contact Email',
            'contact_phone' => 'Contact Phone',
            'contact_address' => 'Address',
            'facebook_url' => 'Facebook URL',
            'twitter_url' => 'Twitter URL',
            'linkedin_url' => 'LinkedIn URL',
            'youtube_url' => 'YouTube URL',
            'hero_title' => 'Hero Title',
            'hero_subtitle' => 'Hero Subtitle',
            'about_short' => 'About Short',
            'mission_statement' => 'Mission Statement',
            'vision_statement' => 'Vision Statement',
            'stats_startups' => 'Startups Incubated',
            'stats_cohorts' => 'Cohorts Completed',
            'stats_jobs' => 'Jobs Created',
            'stats_funding' => 'Funding Raised',
            'footer_text' => 'Footer Text',
            'google_analytics_id' => 'Google Analytics ID',
        ];

        $type = match (true) {
            in_array($key, ['site_logo', 'site_favicon'], true) => 'image',
            in_array($key, ['site_description', 'contact_address', 'hero_subtitle', 'mission_statement', 'vision_statement', 'about_short'], true) => 'textarea',
            default => 'text',
        };

        $group = match (true) {
            in_array($key, ['site_logo', 'site_favicon'], true) => 'branding',
            str_starts_with($key, 'contact_') => 'contact',
            str_ends_with($key, '_url') => 'social',
            str_starts_with($key, 'hero_') => 'hero',
            str_starts_with($key, 'stats_') => 'stats',
            in_array($key, ['footer_text', 'google_analytics_id'], true) => 'footer',
            in_array($key, ['about_short', 'mission_statement', 'vision_statement'], true) => 'about',
            default => 'general',
        };

        return [
            'label' => $labels[$key] ?? Str::title(str_replace('_', ' ', $key)),
            'type' => $type,
            'group' => $group,
        ];
    }
}
