<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Modules\Seo\Models\Seo;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //seo for main pages

        Seo::create([
            'page_name' => 'Home Page',
            'slug' => 'home-page',
        ]);

        Seo::create([
            'page_name' => 'About Page',
            'slug' => 'about-page',
        ]);

        Seo::create([
            'page_name' => 'Contact Page',
            'slug' => 'contact-page',
        ]);

        Seo::create([
            'page_name' => 'Mission And Vision Page',
            'slug' => 'mission-vision-page',
        ]);

        Seo::create([
            'page_name' => 'Leadership Team Page',
            'slug' => 'leadership-page',
        ]);

        Seo::create([
            'page_name' => 'Testimonial Page',
            'slug' => 'testimonial-page',
        ]);

        Seo::create([
            'page_name' => 'Blogs Page',
            'slug' => 'blogs-page',
        ]);

        Seo::create([
            'page_name' => 'Expert Tips Page',
            'slug' => 'expert-tips-page',
        ]);

        Seo::create([
            'page_name' => 'Events Page',
            'slug' => 'events-page',
        ]);

        Seo::create([
            'page_name' => 'Faq Page',
            'slug' => 'faq-page',
        ]);

        Seo::create([
            'page_name' => 'Gallery Page',
            'slug' => 'gallery-page',
        ]);

        Seo::create([
            'page_name' => 'Day Scholar & Residential Page',
            'slug' => 'day-scholar-page',
        ]);

        Seo::create([
            'page_name' => 'Vrddhi Page',
            'slug' => 'vrddhi-page',
        ]);

        Seo::create([
            'page_name' => 'Vrddhi Syllabus Page',
            'slug' => 'vrddhi-syllabus-page',
        ]);

        Seo::create([
            'page_name' => 'PUC Admission Page',
            'slug' => 'puc-page',
        ]);

        Seo::create([
            'page_name' => 'Class 8, 9, 10 Admission Page',
            'slug' => 'not-puc-page',
        ]);

    }
}
