<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name'=>'Dr. Bekele Tadesse','title'=>'Director, BTIC','bio'=>'Dr. Bekele has 15+ years of experience in entrepreneurship development and technology transfer. He leads DDU\'s vision to build East Africa\'s premier incubation ecosystem.','department'=>'Leadership','sort_order'=>1],
            ['name'=>'Tigist Haile','title'=>'Program Manager','bio'=>'Tigist oversees all incubation programs and coordinates between startups, mentors, and university stakeholders to ensure program excellence.','department'=>'Programs','sort_order'=>2],
            ['name'=>'Solomon Gebre','title'=>'Business Development Lead','bio'=>'Solomon connects startups with investors, corporate partners, and market opportunities, having facilitated over $500K in funding for BTIC alumni.','department'=>'Business Development','sort_order'=>3],
            ['name'=>'Meron Abebe','title'=>'Technology Innovation Advisor','bio'=>'Meron brings deep expertise in software engineering and digital transformation, guiding tech startups on product development and scalability.','department'=>'Technology','sort_order'=>4],
            ['name'=>'Dawit Mulugeta','title'=>'Finance & Legal Advisor','bio'=>'Dawit supports startups with financial modeling, fundraising strategy, legal compliance, and investor relations.','department'=>'Finance & Legal','sort_order'=>5],
            ['name'=>'Hana Yohannes','title'=>'Community & Events Coordinator','bio'=>'Hana builds the BTIC community through events, workshops, alumni engagement, and strategic communications.','department'=>'Community','sort_order'=>6],
        ];
        foreach ($members as $m) {
            TeamMember::updateOrCreate(['name' => $m['name']], array_merge($m, ['is_active' => true]));
        }
    }
}
