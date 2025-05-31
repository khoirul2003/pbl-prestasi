<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Skill::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = Category::pluck('category_id', 'category_name');

        // Innovation & Technology
        Skill::create(['skill_name' => 'Artificial Intelligence', 'category_id' => $categories['Innovation & Technology']]);
        Skill::create(['skill_name' => 'Machine Learning', 'category_id' => $categories['Innovation & Technology']]);
        Skill::create(['skill_name' => 'Data Science', 'category_id' => $categories['Innovation & Technology']]);
        Skill::create(['skill_name' => 'Cloud Computing', 'category_id' => $categories['Innovation & Technology']]);
        Skill::create(['skill_name' => 'Cybersecurity', 'category_id' => $categories['Innovation & Technology']]);

        // Business & Entrepreneurship
        Skill::create(['skill_name' => 'Business Strategy', 'category_id' => $categories['Business & Entrepreneurship']]);
        Skill::create(['skill_name' => 'Marketing', 'category_id' => $categories['Business & Entrepreneurship']]);
        Skill::create(['skill_name' => 'Financial Analysis', 'category_id' => $categories['Business & Entrepreneurship']]);
        Skill::create(['skill_name' => 'Sales', 'category_id' => $categories['Business & Entrepreneurship']]);
        Skill::create(['skill_name' => 'Project Management', 'category_id' => $categories['Business & Entrepreneurship']]);

        // Design & Creative Arts
        Skill::create(['skill_name' => 'Graphic Design', 'category_id' => $categories['Design & Creative Arts']]);
        Skill::create(['skill_name' => 'UX/UI Design', 'category_id' => $categories['Design & Creative Arts']]);
        Skill::create(['skill_name' => 'Photography', 'category_id' => $categories['Design & Creative Arts']]);
        Skill::create(['skill_name' => 'Video Editing', 'category_id' => $categories['Design & Creative Arts']]);
        Skill::create(['skill_name' => 'Animation', 'category_id' => $categories['Design & Creative Arts']]);

        // E-Sports & Gaming
        Skill::create(['skill_name' => 'Game Development', 'category_id' => $categories['E-Sports & Gaming']]);
        Skill::create(['skill_name' => 'Game Streaming', 'category_id' => $categories['E-Sports & Gaming']]);
        Skill::create(['skill_name' => 'Competitive Gaming', 'category_id' => $categories['E-Sports & Gaming']]);
        Skill::create(['skill_name' => 'Game Design', 'category_id' => $categories['E-Sports & Gaming']]);
        Skill::create(['skill_name' => 'Game Testing', 'category_id' => $categories['E-Sports & Gaming']]);

        // Academic & Research
        Skill::create(['skill_name' => 'Scientific Research', 'category_id' => $categories['Academic & Research']]);
        Skill::create(['skill_name' => 'Data Analysis', 'category_id' => $categories['Academic & Research']]);
        Skill::create(['skill_name' => 'Academic Writing', 'category_id' => $categories['Academic & Research']]);
        Skill::create(['skill_name' => 'Laboratory Techniques', 'category_id' => $categories['Academic & Research']]);
        Skill::create(['skill_name' => 'Grant Writing', 'category_id' => $categories['Academic & Research']]);

        // Arts & Culture
        Skill::create(['skill_name' => 'Music', 'category_id' => $categories['Arts & Culture']]);
        Skill::create(['skill_name' => 'Dance', 'category_id' => $categories['Arts & Culture']]);
        Skill::create(['skill_name' => 'Theater', 'category_id' => $categories['Arts & Culture']]);
        Skill::create(['skill_name' => 'Painting', 'category_id' => $categories['Arts & Culture']]);
        Skill::create(['skill_name' => 'Sculpture', 'category_id' => $categories['Arts & Culture']]);

        // Sports
        Skill::create(['skill_name' => 'Football', 'category_id' => $categories['Sports']]);
        Skill::create(['skill_name' => 'Basketball', 'category_id' => $categories['Sports']]);
        Skill::create(['skill_name' => 'Athletics', 'category_id' => $categories['Sports']]);
        Skill::create(['skill_name' => 'Swimming', 'category_id' => $categories['Sports']]);
        Skill::create(['skill_name' => 'Martial Arts', 'category_id' => $categories['Sports']]);

        // Leadership & Organization
        Skill::create(['skill_name' => 'Team Leadership', 'category_id' => $categories['Leadership & Organization']]);
        Skill::create(['skill_name' => 'Event Planning', 'category_id' => $categories['Leadership & Organization']]);
        Skill::create(['skill_name' => 'Negotiation', 'category_id' => $categories['Leadership & Organization']]);
        Skill::create(['skill_name' => 'Public Speaking', 'category_id' => $categories['Leadership & Organization']]);
        Skill::create(['skill_name' => 'Conflict Resolution', 'category_id' => $categories['Leadership & Organization']]);

        // Social & Environmental
        Skill::create(['skill_name' => 'Community Service', 'category_id' => $categories['Social & Environmental']]);
        Skill::create(['skill_name' => 'Environmental Conservation', 'category_id' => $categories['Social & Environmental']]);
        Skill::create(['skill_name' => 'Social Advocacy', 'category_id' => $categories['Social & Environmental']]);
        Skill::create(['skill_name' => 'Fundraising', 'category_id' => $categories['Social & Environmental']]);
        Skill::create(['skill_name' => 'Volunteer Coordination', 'category_id' => $categories['Social & Environmental']]);
    }
}
