<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        if (!$admin) return;

        $articles = [
            ['title'=>'BTIC Launches Cohort 6 Applications — 20 Spots for Innovative Startups','excerpt'=>'Dire Dawa University BTIC opens applications for its sixth incubation cohort, targeting AgriTech, HealthTech, and FinTech startups across Ethiopia.','content'=>'<p>Dire Dawa University\'s Business and Technology Incubation Center (BTIC) is thrilled to announce the opening of applications for <strong>Cohort 6</strong>, our most ambitious program to date.</p><p>This cohort will accept up to 20 high-potential startups across sectors including AgriTech, HealthTech, FinTech, and EdTech. Selected startups will receive six months of intensive support including co-working space, mentorship, access to university research facilities, and investment connections.</p><h2>What We Offer</h2><ul><li>ETB 500,000 in seed funding for top performers</li><li>Access to DDU research labs and technical expertise</li><li>Mentorship from experienced entrepreneurs and industry experts</li><li>Legal, financial, and business development support</li><li>Demo Day with investors and corporate partners</li></ul><p>Applications are open from September 1 to October 31, 2024. Apply at btic.ddu.edu.et.</p>','category'=>'Announcements','is_featured'=>true,'is_published'=>true,'published_at'=>now()->subDays(5),'tags'=>['cohort','applications','incubation','startup']],
            ['title'=>'AgroLink Ethiopia Raises $50K Seed Funding — BTIC\'s Success Story','excerpt'=>'AgroLink, a BTIC Cohort 4 graduate, successfully closes a $50K seed round from East African angel investors, set to scale to three new regions.','content'=>'<p>In a landmark achievement for the DDU BTIC ecosystem, <strong>AgroLink Ethiopia</strong> has secured $50,000 in seed funding from a consortium of East African angel investors, just 18 months after graduating from Cohort 4.</p><p>Founded by Abebe Girma, AgroLink has connected over 2,500 smallholder farmers to buyers in Dire Dawa, Addis Ababa, and the Somali region — increasing average farmer income by 40%. The new funding will accelerate expansion to Harari, Oromia, and Amhara regions.</p><p>"BTIC gave us the foundation to build something real," said Abebe Girma, CEO of AgroLink. "The mentorship, the network, and the facilities were exactly what we needed to validate and scale."</p>','category'=>'Success Stories','is_featured'=>true,'is_published'=>true,'published_at'=>now()->subDays(12),'tags'=>['agrolink','funding','success','agritech']],
            ['title'=>'DDU BTIC Partners with Ethio Telecom for Digital Innovation Program','excerpt'=>'A new MOU between DDU BTIC and Ethio Telecom will provide BTIC startups with cloud credits, API access, and digital infrastructure support.','content'=>'<p>Dire Dawa University BTIC has signed a Memorandum of Understanding with <strong>Ethio Telecom</strong>, Ethiopia\'s state telecommunications company, to launch a joint Digital Innovation Support Program for BTIC startups.</p><p>Under this partnership, BTIC-incubated startups will benefit from:</p><ul><li>ETB 200,000 in annual cloud computing credits</li><li>Priority access to Ethio Telecom developer APIs</li><li>Co-marketing opportunities with Ethio Telecom</li><li>Potential commercial contracts for validated solutions</li></ul><p>The partnership underscores the growing recognition of DDU BTIC as a strategic innovation partner for Ethiopia\'s corporate sector.</p>','category'=>'Partnerships','is_published'=>true,'published_at'=>now()->subDays(20),'tags'=>['partnership','ethiotelecom','digital','infrastructure']],
            ['title'=>'HealthPulse Reaches 10,000 Telemedicine Consultations Milestone','excerpt'=>'BTIC Cohort 4 graduate HealthPulse celebrates a major milestone, having served over 10,000 patients across 8 Ethiopian cities via telemedicine.','content'=>'<p><strong>HealthPulse</strong>, founded by Dr. Selam Bekele and incubated at DDU BTIC, has reached a landmark of 10,000 telemedicine consultations, bringing affordable healthcare to communities across 8 Ethiopian cities.</p><p>The platform now hosts 45 certified physicians and has expanded its services to include mental health counseling, maternal care, and chronic disease management — all accessible via a simple mobile app.</p>','category'=>'Success Stories','is_published'=>true,'published_at'=>now()->subDays(30),'tags'=>['healthpulse','healthtech','milestone','telemedicine']],
            ['title'=>'Apply Now: BTIC Innovation Challenge 2024 — ETB 300,000 in Prizes','excerpt'=>'BTIC announces its annual Innovation Challenge open to all Ethiopian university students and recent graduates with prizes totaling ETB 300,000.','content'=>'<p>The annual <strong>BTIC Innovation Challenge</strong> is back! We are calling on all Ethiopian university students and recent graduates (within 2 years) to submit their most innovative ideas for a chance to win from a prize pool of <strong>ETB 300,000</strong>.</p><p>This year\'s challenge focuses on solutions that address local challenges in agriculture, healthcare, education, or clean energy using technology.</p><h2>Timeline</h2><ul><li>Application Opens: November 1, 2024</li><li>Shortlist Announced: December 1, 2024</li><li>Final Pitch Day: December 20, 2024</li></ul>','category'=>'Events','is_published'=>true,'published_at'=>now()->subDays(3),'tags'=>['challenge','innovation','competition','prizes']],
        ];

        foreach ($articles as $a) {
            News::updateOrCreate(['title' => $a['title']], array_merge($a, [
                'author_id' => $admin->id,
                'slug'      => Str::slug($a['title']),
                'views'     => rand(50, 800),
            ]));
        }
    }
}
