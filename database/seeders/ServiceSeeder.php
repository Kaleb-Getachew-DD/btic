<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['title'=>'Co-working Space','description'=>'State-of-the-art collaborative workspace with high-speed internet, meeting rooms, and innovation labs available 24/7.','icon'=>'fa-building','category'=>'Infrastructure','features'=>['High-speed fiber internet','Private meeting rooms','Innovation labs','3D printing & prototyping'],'sort_order'=>1],
            ['title'=>'Mentorship & Coaching','description'=>'One-on-one and group mentorship from experienced entrepreneurs, industry experts, and successful founders.','icon'=>'fa-users','category'=>'Advisory','features'=>['Expert mentor matching','Weekly coaching sessions','Peer learning circles','Guest speaker series'],'sort_order'=>2],
            ['title'=>'Funding & Investment','description'=>'Access to seed funding, angel investors, and venture capital networks to fuel your startup growth.','icon'=>'fa-coins','category'=>'Finance','features'=>['Seed grant up to ETB 500K','Angel investor network','VC introductions','Pitch competition prizes'],'sort_order'=>3],
            ['title'=>'Legal & Compliance','description'=>'Complete legal support for company registration, IP protection, contracts, and regulatory compliance.','icon'=>'fa-balance-scale','category'=>'Legal','features'=>['Company registration','IP filing support','Contract templates','Regulatory guidance'],'sort_order'=>4],
            ['title'=>'Market Access','description'=>'Leverage DDU networks and corporate partnerships for pilot programs, sales channels, and market entry.','icon'=>'fa-globe','category'=>'Market','features'=>['Corporate pilot programs','B2G procurement support','Export market guidance','Partnership referrals'],'sort_order'=>5],
            ['title'=>'Technology & R&D','description'=>'Access to university research facilities, tech infrastructure, and academic expertise for R&D activities.','icon'=>'fa-flask','category'=>'Technology','features'=>['University lab access','R&D collaboration','Software licenses','Cloud computing credits'],'sort_order'=>6],
        ];
        foreach ($services as $s) {
            Service::updateOrCreate(['title' => $s['title']], array_merge($s, ['is_active' => true]));
        }
    }
}
