<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            ['key' => 'president_image', 'value' => '', 'type' => 'image', 'group' => 'about', 'label' => 'University President Portrait'],
            ['key' => 'president_name', 'value' => '', 'type' => 'text', 'group' => 'about', 'label' => 'University President Name'],
            ['key' => 'president_title', 'value' => 'Our University President', 'type' => 'text', 'group' => 'about', 'label' => 'President Title Label'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }

    public function down(): void
    {
        Setting::whereIn('key', [
            'president_image',
            'president_name',
            'president_title',
        ])->delete();
    }
};
