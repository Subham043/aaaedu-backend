<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class OtherPermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //permission unrelated to main app

        //permission for blogs
        Permission::create(['name' => 'edit blogs']);
        Permission::create(['name' => 'delete blogs']);
        Permission::create(['name' => 'create blogs']);
        Permission::create(['name' => 'list blogs']);

        //permission for events
        Permission::create(['name' => 'edit events']);
        Permission::create(['name' => 'delete events']);
        Permission::create(['name' => 'create events']);
        Permission::create(['name' => 'list events']);

        //permission for counters
        Permission::create(['name' => 'edit counters']);
        Permission::create(['name' => 'delete counters']);
        Permission::create(['name' => 'create counters']);
        Permission::create(['name' => 'list counters']);

        //permission for testimonials
        Permission::create(['name' => 'edit testimonials']);
        Permission::create(['name' => 'delete testimonials']);
        Permission::create(['name' => 'create testimonials']);
        Permission::create(['name' => 'list testimonials']);

        //permission for expert tips
        Permission::create(['name' => 'edit expert tips']);
        Permission::create(['name' => 'delete expert tips']);
        Permission::create(['name' => 'create expert tips']);
        Permission::create(['name' => 'list expert tips']);

        //permission for home page content
        Permission::create(['name' => 'edit home page content']);
        Permission::create(['name' => 'delete home page content']);
        Permission::create(['name' => 'create home page content']);
        Permission::create(['name' => 'list home page content']);

        //permission for about section content
        Permission::create(['name' => 'edit about section content']);

        //permission for features
        Permission::create(['name' => 'edit features']);
        Permission::create(['name' => 'delete features']);
        Permission::create(['name' => 'create features']);
        Permission::create(['name' => 'list features']);

        //permission for faqs
        Permission::create(['name' => 'edit faqs']);
        Permission::create(['name' => 'delete faqs']);
        Permission::create(['name' => 'create faqs']);
        Permission::create(['name' => 'list faqs']);

        //permission for team member managements
        Permission::create(['name' => 'edit team member managements']);
        Permission::create(['name' => 'delete team member managements']);
        Permission::create(['name' => 'create team member managements']);
        Permission::create(['name' => 'list team member managements']);

        //permission for team member staffs
        Permission::create(['name' => 'edit team member staffs']);
        Permission::create(['name' => 'delete team member staffs']);
        Permission::create(['name' => 'create team member staffs']);
        Permission::create(['name' => 'list team member staffs']);

        //permission for team member course
        Permission::create(['name' => 'edit team member course']);
        Permission::create(['name' => 'delete team member course']);
        Permission::create(['name' => 'create team member course']);
        Permission::create(['name' => 'list team member course']);

        //permission for achievers
        Permission::create(['name' => 'edit achievers']);
        Permission::create(['name' => 'delete achievers']);
        Permission::create(['name' => 'create achievers']);
        Permission::create(['name' => 'list achievers']);

        //permission for admissions
        Permission::create(['name' => 'edit admissions']);
        Permission::create(['name' => 'delete admissions']);
        Permission::create(['name' => 'create admissions']);
        Permission::create(['name' => 'list admissions']);

        //permission for galleries
        Permission::create(['name' => 'edit galleries']);
        Permission::create(['name' => 'delete galleries']);
        Permission::create(['name' => 'create galleries']);
        Permission::create(['name' => 'list galleries']);

        //permission for campaigns
        Permission::create(['name' => 'edit campaigns']);
        Permission::create(['name' => 'delete campaigns']);
        Permission::create(['name' => 'create campaigns']);
        Permission::create(['name' => 'list campaigns']);

        //permission for courses
        Permission::create(['name' => 'edit courses']);
        Permission::create(['name' => 'delete courses']);
        Permission::create(['name' => 'create courses']);
        Permission::create(['name' => 'list courses']);

        //permission for pages seo
        Permission::create(['name' => 'edit pages seo']);
        Permission::create(['name' => 'list pages seo']);

        //permission for mission vision
        Permission::create(['name' => 'edit mission vision']);
        Permission::create(['name' => 'list mission vision']);

        //permission for tests
        Permission::create(['name' => 'edit tests']);
        Permission::create(['name' => 'delete tests']);
        Permission::create(['name' => 'create tests']);
        Permission::create(['name' => 'list tests']);

    }
}
