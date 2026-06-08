<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            ['key' => 'university_logo', 'value' => '', 'type' => 'image', 'group' => 'branding', 'label' => 'University Logo'],
            ['key' => 'university_name', 'value' => 'DDU', 'type' => 'text', 'group' => 'branding', 'label' => 'University Badge Abbreviation'],
            ['key' => 'university_subtitle', 'value' => 'Dire Dawa University', 'type' => 'text', 'group' => 'branding', 'label' => 'University Name'],
            ['key' => 'university_url', 'value' => '', 'type' => 'text', 'group' => 'branding', 'label' => 'University Website URL'],
            ['key' => 'partnership_title', 'value' => 'Our Partners & Collaborators', 'type' => 'text', 'group' => 'partnerships', 'label' => 'Partnership Section Title'],
            ['key' => 'partnership_subtitle', 'value' => 'Working together with leading institutions and organizations to build Ethiopia\'s innovation ecosystem.', 'type' => 'textarea', 'group' => 'partnerships', 'label' => 'Partnership Section Subtitle'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }

    public function down(): void
    {
        Setting::whereIn('key', [
            'university_logo', 'university_name', 'university_subtitle', 'university_url',
            'partnership_title', 'partnership_subtitle',
        ])->delete();
    }
};
