<?php
// FILE: database/seeders/StartupSeeder.php
namespace Database\Seeders;
use App\Models\Startup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StartupSeeder extends Seeder
{
    public function run(): void
    {
        $startups = [
            ['name'=>'AgroLink Ethiopia','tagline'=>'Connecting Farmers to Markets Digitally','description'=>'AgroLink is a digital marketplace connecting smallholder farmers directly to buyers, eliminating middlemen and increasing farmer income by up to 40%.','sector'=>'AgriTech','founder_name'=>'Abebe Girma','founder_title'=>'CEO & Co-Founder','team_size'=>8,'stage'=>'early_traction','cohort_batch'=>'Cohort 4','founded_year'=>'2022','location'=>'Dire Dawa','metrics'=>['farmers'=>'2,500+','revenue'=>'ETB 800K','buyers'=>'120+'],'achievements'=>['Best AgriTech Startup Award 2023','Raised $50K seed funding','Featured in Addis Fortune'],'is_featured'=>true,'sort_order'=>1],
            ['name'=>'HealthPulse','tagline'=>'Telemedicine for Everyone, Everywhere','description'=>'HealthPulse provides affordable telemedicine services to underserved communities in Ethiopia, connecting patients with certified physicians via mobile.','sector'=>'HealthTech','founder_name'=>'Dr. Selam Bekele','founder_title'=>'Founder & CMO','team_size'=>6,'stage'=>'growth','cohort_batch'=>'Cohort 4','founded_year'=>'2022','location'=>'Dire Dawa','metrics'=>['consultations'=>'10,000+','doctors'=>'45','cities'=>'8'],'achievements'=>['USAID HealthTech Grant recipient','15,000 app downloads','Partnership with DDU Medical School'],'is_featured'=>true,'sort_order'=>2],
            ['name'=>'EduReach','tagline'=>'Quality Education, No Boundaries','description'=>'EduReach delivers adaptive e-learning content for K-12 students in Ethiopia using AI, supporting local languages including Amharic, Somali, and Afar.','sector'=>'EdTech','founder_name'=>'Rahel Tadesse','founder_title'=>'CEO','team_size'=>10,'stage'=>'growth','cohort_batch'=>'Cohort 5','founded_year'=>'2023','location'=>'Dire Dawa','metrics'=>['students'=>'8,000+','schools'=>'35','languages'=>'3'],'achievements'=>['Ministry of Education partnership','Winner EduTech East Africa 2023','$80K raised'],'is_featured'=>true,'sort_order'=>3],
            ['name'=>'PayEasy','tagline'=>'Financial Inclusion Through Mobile Payments','description'=>'PayEasy is a mobile-first fintech solution enabling micro-merchants and SMEs in eastern Ethiopia to accept digital payments and access microloans.','sector'=>'FinTech','founder_name'=>'Yonas Haile','founder_title'=>'CTO & Co-Founder','team_size'=>7,'stage'=>'early_traction','cohort_batch'=>'Cohort 5','founded_year'=>'2023','location'=>'Dire Dawa','metrics'=>['merchants'=>'500+','transactions'=>'ETB 2M+','loans_disbursed'=>'ETB 1.2M'],'achievements'=>['NBE FinTech Sandbox member','Partnership with Commercial Bank','$30K startup grant'],'is_featured'=>true,'sort_order'=>4],
            ['name'=>'CleanDrive','tagline'=>'Electric Mobility for Ethiopian Cities','description'=>'CleanDrive develops affordable electric three-wheelers (Bajaj) for urban transport, reducing emissions and fuel costs for local drivers.','sector'=>'CleanTech','founder_name'=>'Mikias Solomon','founder_title'=>'Founder','team_size'=>5,'stage'=>'prototype','cohort_batch'=>'Cohort 5','founded_year'=>'2023','location'=>'Dire Dawa','metrics'=>['prototypes'=>'3','pilots'=>'2','emissions_saved'=>'5T CO2'],'achievements'=>['UNEP Climate Innovation Prize finalist','DDU R&D partnership','ETB 200K prototype grant'],'is_featured'=>false,'sort_order'=>5],
            ['name'=>'LogiTrack','tagline'=>'Last-Mile Logistics, Made Simple','description'=>'LogiTrack optimizes last-mile delivery for e-commerce businesses in Ethiopia using AI route planning and a crowdsourced delivery network.','sector'=>'LogisticsTech','founder_name'=>'Biruk Alemu','founder_title'=>'CEO','team_size'=>9,'stage'=>'early_traction','cohort_batch'=>'Cohort 4','founded_year'=>'2022','location'=>'Dire Dawa','metrics'=>['deliveries'=>'5,000+','partners'=>'20 e-commerce','riders'=>'150'],'achievements'=>['DHL Ethiopia partnership','Best Logistics Startup 2023','$45K raised'],'is_featured'=>false,'sort_order'=>6],
        ];
        foreach ($startups as $s) {
            Startup::updateOrCreate(['name'=>$s['name']], array_merge($s, ['slug'=>Str::slug($s['name']),'is_active'=>true]));
        }
    }
}
