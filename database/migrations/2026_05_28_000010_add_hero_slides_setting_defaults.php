<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        $now = now();

        $defaults = [
            'hero_title' => 'Where Innovation Meets Opportunity',
            'hero_subtitle' => 'Dire Dawa University BTIC empowers entrepreneurs to validate ideas, build scalable products, and connect with investors.',
            'hero_slides' => json_encode([
                [
                    'img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=700&q=85&auto=format&fit=crop',
                    'caption' => 'Collaborative Innovation',
                    'sub' => 'Teams building the future',
                    'tag' => 'Pre-Incubation & Ideation',
                    'line1' => 'Where Innovation',
                    'line2' => 'Meets Opportunity',
                    'desc' => 'Dire Dawa University BTIC empowers bold entrepreneurs to validate ideas, build scalable products, and connect with investors — from first concept to market-ready launch.',
                    'label' => 'Collaborative Innovation',
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=700&q=85&auto=format&fit=crop',
                    'caption' => 'World-Class Workspace',
                    'sub' => 'State-of-the-art co-working facilities',
                    'tag' => 'Core Incubation Program',
                    'line1' => "Empowering Tomorrow's",
                    'line2' => 'Entrepreneurs',
                    'desc' => 'Our 6-month core incubation program provides co-working space, expert mentorship, legal guidance, and direct funding pathways for high-potential startups.',
                    'label' => 'World-Class Workspace',
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=700&q=85&auto=format&fit=crop',
                    'caption' => 'Technology at the Core',
                    'sub' => 'Leveraging DDU research infrastructure',
                    'tag' => 'Technology & R&D Access',
                    'line1' => 'Technology-Driven',
                    'line2' => 'Transformation',
                    'desc' => "Leverage Dire Dawa University's research infrastructure, cloud computing credits, software licenses, and academic expertise to build better products faster.",
                    'label' => 'Technology at the Core',
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=700&q=85&auto=format&fit=crop',
                    'caption' => 'Pitch to Investors',
                    'sub' => 'Demo Day & funding connections',
                    'tag' => 'Investment & Market Access',
                    'line1' => 'Connecting Ideas',
                    'line2' => 'to Capital',
                    'desc' => 'Access our network of angel investors, venture capital firms, and Demo Day platforms. Our alumni have raised over $1M USD in cumulative funding.',
                    'label' => 'Pitch to Investors',
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1600880292089-90a7e086ee0c?w=700&q=85&auto=format&fit=crop',
                    'caption' => 'Expert Mentorship',
                    'sub' => '200+ mentors across industries',
                    'tag' => 'Mentorship & Growth',
                    'line1' => "Building East Africa's",
                    'line2' => 'Future Leaders',
                    'desc' => 'Join 200+ mentors, 60+ successful alumni startups, and a thriving community of founders building solutions that serve Ethiopia and beyond.',
                    'label' => 'Expert Mentorship',
                ],
            ]),
        ];

        foreach ($defaults as $key => $value) {
            $existing = DB::table('settings')->where('key', $key)->first();
            if ($existing) {
                continue;
            }

            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value,
                'type' => $key === 'hero_slides' ? 'json' : (Str::contains($key, 'subtitle') ? 'textarea' : 'text'),
                'group' => 'hero',
                'label' => Str::title(str_replace('_', ' ', $key)),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['hero_slides'])->delete();
    }
};

