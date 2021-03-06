<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Dean;
use App\Models\Department;
use App\Models\Course;

use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Admin::create([
            "f_name" => "admin",
            "l_name" => "admin",
            "username" => "admin",
            "plain_password" => "admin",
            "password" => Hash::make("admin")
        ]);
        Dean::create([
            "f_name" => "dean",
            "l_name" => "dean",
            "username" => "dean",
            "plain_password" => "dean",
            "password" => Hash::make("dean")
        ]);
        Department::create([
            "department_name" => "CECS",
        ]);
        Course::create([
            "course_name" => "BSIT",
            "department_id" => "1"
        ]);
        Student::create([
            "f_name" => "student",
            "l_name" => "student",
            "username" => "student",
            "course_id" => "1",
            "plain_password" => "student",
            "password" => Hash::make("student")
        ]);
    }
}
