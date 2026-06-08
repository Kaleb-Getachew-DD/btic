<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['name' => 'Dire Dawa University', 'description' => 'Our parent institution providing research infrastructure, academic expertise, and campus facilities.', 'sort_order' => 1],
            ['name' => 'Ministry of Innovation', 'description' => 'National partner supporting entrepreneurship policy and startup ecosystem development.', 'sort_order' => 2],
            ['name' => 'Ethiopian Investment Commission', 'description' => 'Facilitating investment pathways and regulatory support for incubated startups.', 'sort_order' => 3],
            ['name' => 'Tech Hub Africa', 'description' => 'Regional technology network connecting BTIC startups to pan-African markets.', 'sort_order' => 4],
            ['name' => 'Green Growth Initiative', 'description' => 'Supporting climate-tech and sustainable innovation ventures from our portfolio.', 'sort_order' => 5],
            ['name' => 'DDU Research Center', 'description' => 'Collaborative R&D partner offering labs, equipment, and faculty mentorship.', 'sort_order' => 6],
        ];

        foreach ($partners as $partner) {
            Partner::updateOrCreate(
                ['name' => $partner['name']],
                array_merge($partner, ['is_active' => true])
            );
        }
    }
}
