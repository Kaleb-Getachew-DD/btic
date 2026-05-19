<?php
// FILE: database/seeders/ProgramSeeder.php
namespace Database\Seeders;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            ['title'=>'Pre-Incubation','short_description'=>'Validate your idea before committing full-time. A 3-month ideation and validation program.','icon'=>'fa-lightbulb','duration'=>'3 Months','eligibility'=>'Students, graduates, and early-stage entrepreneurs with a business idea.','benefits'=>['Idea validation workshops','Mentorship sessions','Market research support','Networking events','Access to BTIC labs'],'sort_order'=>1],
            ['title'=>'Core Incubation','short_description'=>'Full incubation program for startups ready to build and launch their MVP.','icon'=>'fa-rocket','duration'=>'6 Months','eligibility'=>'Startups with validated idea and committed founding team.','benefits'=>['Co-working space','Technical mentorship','Business development support','Legal & compliance guidance','Investor introductions','Seed funding opportunity'],'sort_order'=>2],
            ['title'=>'Acceleration','short_description'=>'Scale your startup with access to markets, funding, and strategic partnerships.','icon'=>'fa-chart-line','duration'=>'4 Months','eligibility'=>'Post-MVP startups with initial traction and revenue.','benefits'=>['Series A preparation','Corporate partnerships','International market access','Demo Day pitching','Strategic advisory board'],'sort_order'=>3],
            ['title'=>'Graduate Support','short_description'=>'Ongoing support for BTIC alumni to sustain and grow beyond the program.','icon'=>'fa-graduation-cap','duration'=>'Ongoing','eligibility'=>'BTIC program graduates.','benefits'=>['Alumni network access','Continued mentorship','Co-investment opportunities','Partnership referrals'],'sort_order'=>4],
        ];
        foreach ($programs as $p) { Program::updateOrCreate(['title'=>$p['title']], array_merge($p, ['slug'=>Str::slug($p['title']),'is_active'=>true])); }
    }
}
