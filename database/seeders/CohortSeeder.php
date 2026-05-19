<?php
// FILE: database/seeders/CohortSeeder.php
namespace Database\Seeders;
use App\Models\Cohort;
use Illuminate\Database\Seeder;

class CohortSeeder extends Seeder
{
    public function run(): void
    {
        $cohorts = [
            ['name'=>'BTIC Cohort 6','batch_number'=>6,'description'=>'Our flagship 6th cohort focusing on AgriTech, HealthTech, and FinTech innovations.','application_start'=>'2024-09-01','application_end'=>'2024-10-31','program_start'=>'2024-11-15','program_end'=>'2025-05-15','max_startups'=>20,'status'=>'open','focus_areas'=>['AgriTech','HealthTech','FinTech','EdTech']],
            ['name'=>'BTIC Cohort 5','batch_number'=>5,'description'=>'Fifth cohort with focus on sustainable technologies and digital solutions.','application_start'=>'2023-09-01','application_end'=>'2023-10-31','program_start'=>'2023-11-15','program_end'=>'2024-05-15','max_startups'=>18,'status'=>'completed','focus_areas'=>['CleanTech','EdTech','E-commerce']],
            ['name'=>'BTIC Cohort 4','batch_number'=>4,'description'=>'Fourth incubation cohort targeting logistics and supply chain innovations.','application_start'=>'2022-09-01','application_end'=>'2022-10-31','program_start'=>'2022-11-01','program_end'=>'2023-04-30','max_startups'=>15,'status'=>'completed','focus_areas'=>['LogisticsTech','SupplyChain','Mobile']],
        ];
        foreach ($cohorts as $c) { Cohort::updateOrCreate(['batch_number'=>$c['batch_number']], array_merge($c, ['slug'=>\Illuminate\Support\Str::slug($c['name'])])); }
    }
}
