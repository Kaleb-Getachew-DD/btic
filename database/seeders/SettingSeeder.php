<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key'=>'site_name',        'value'=>'DDU BTIC',                                    'type'=>'text',     'group'=>'general', 'label'=>'Site Name'],
            ['key'=>'site_tagline',     'value'=>'Empowering Innovation, Building Tomorrow',    'type'=>'text',     'group'=>'general', 'label'=>'Site Tagline'],
            ['key'=>'site_description', 'value'=>'Dire Dawa University Business and Technology Incubation Center — nurturing entrepreneurs to build scalable, impactful startups.', 'type'=>'textarea', 'group'=>'general', 'label'=>'Site Description'],
            ['key'=>'contact_email',    'value'=>'btic@ddu.edu.et',                             'type'=>'text',     'group'=>'contact', 'label'=>'Contact Email'],
            ['key'=>'contact_phone',    'value'=>'+251 25 111 0000',                            'type'=>'text',     'group'=>'contact', 'label'=>'Contact Phone'],
            ['key'=>'contact_address',  'value'=>'Dire Dawa University, P.O. Box 1362, Dire Dawa, Ethiopia', 'type'=>'textarea', 'group'=>'contact', 'label'=>'Address'],
            // Social
            ['key'=>'facebook_url',     'value'=>'https://facebook.com/ddubtic',                'type'=>'text',     'group'=>'social',  'label'=>'Facebook URL'],
            ['key'=>'twitter_url',      'value'=>'https://twitter.com/ddubtic',                  'type'=>'text',     'group'=>'social',  'label'=>'Twitter URL'],
            ['key'=>'linkedin_url',     'value'=>'https://linkedin.com/company/ddubtic',         'type'=>'text',     'group'=>'social',  'label'=>'LinkedIn URL'],
            ['key'=>'youtube_url',      'value'=>'',                                             'type'=>'text',     'group'=>'social',  'label'=>'YouTube URL'],
            // Hero
            ['key'=>'hero_title',       'value'=>'Where Innovation Meets Opportunity',           'type'=>'text',     'group'=>'hero',    'label'=>'Hero Title'],
            ['key'=>'hero_subtitle',    'value'=>'Join the Dire Dawa University BTIC — Ethiopia\'s premier incubation hub for tech-driven startups.', 'type'=>'textarea', 'group'=>'hero', 'label'=>'Hero Subtitle'],
            // Stats
            ['key'=>'stats_startups',   'value'=>'60+',  'type'=>'text', 'group'=>'stats', 'label'=>'Startups Incubated'],
            ['key'=>'stats_cohorts',    'value'=>'6',    'type'=>'text', 'group'=>'stats', 'label'=>'Cohorts Completed'],
            ['key'=>'stats_jobs',       'value'=>'300+', 'type'=>'text', 'group'=>'stats', 'label'=>'Jobs Created'],
            ['key'=>'stats_funding',    'value'=>'$1M+', 'type'=>'text', 'group'=>'stats', 'label'=>'Funding Raised'],
            // Footer
            ['key'=>'footer_text',      'value'=>'© ' . date('Y') . ' Dire Dawa University BTIC. All rights reserved.', 'type'=>'text', 'group'=>'footer', 'label'=>'Footer Text'],
            ['key'=>'site_logo',        'value'=>'',                                             'type'=>'image',    'group'=>'branding', 'label'=>'Site Logo'],
            ['key'=>'site_favicon',     'value'=>'',                                             'type'=>'image',    'group'=>'branding', 'label'=>'Site Favicon'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
