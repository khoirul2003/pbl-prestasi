<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::create(['skill_name' => 'Artificial Intelligence']);
        Skill::create(['skill_name' => 'Machine Learning']);
        Skill::create(['skill_name' => 'Data Science']);
        Skill::create(['skill_name' => 'Cloud Computing']);
        Skill::create(['skill_name' => 'Cybersecurity']);

        // Business & Entrepreneurship
        Skill::create(['skill_name' => 'Business Strategy']);
        Skill::create(['skill_name' => 'Marketing']);
        Skill::create(['skill_name' => 'Financial Analysis']);
        Skill::create(['skill_name' => 'Sales']);
        Skill::create(['skill_name' => 'Project Management']);

        // Design & Creative Arts
        Skill::create(['skill_name' => 'Graphic Design']);
        Skill::create(['skill_name' => 'UX/UI Design']);
        Skill::create(['skill_name' => 'Photography']);
        Skill::create(['skill_name' => 'Video Editing']);
        Skill::create(['skill_name' => 'Animation']);

        // E-Sports & Gaming
        Skill::create(['skill_name' => 'Game Development']);
        Skill::create(['skill_name' => 'Game Streaming']);
        Skill::create(['skill_name' => 'Competitive Gaming']);
        Skill::create(['skill_name' => 'Game Design']);
        Skill::create(['skill_name' => 'Game Testing']);

        // Academic & Research
        Skill::create(['skill_name' => 'Scientific Research']);
        Skill::create(['skill_name' => 'Data Analysis']);
        Skill::create(['skill_name' => 'Academic Writing']);
        Skill::create(['skill_name' => 'Laboratory Techniques']);
        Skill::create(['skill_name' => 'Grant Writing']);

        // Arts & Culture
        Skill::create(['skill_name' => 'Music']);
        Skill::create(['skill_name' => 'Dance']);
        Skill::create(['skill_name' => 'Theater']);
        Skill::create(['skill_name' => 'Painting']);
        Skill::create(['skill_name' => 'Sculpture']);

        // Sports
        Skill::create(['skill_name' => 'Football']);
        Skill::create(['skill_name' => 'Basketball']);
        Skill::create(['skill_name' => 'Athletics']);
        Skill::create(['skill_name' => 'Swimming']);
        Skill::create(['skill_name' => 'Martial Arts']);

        Skill::create(['skill_name' => 'Team Leadership']);
        Skill::create(['skill_name' => 'Event Planning']);
        Skill::create(['skill_name' => 'Negotiation']);
        Skill::create(['skill_name' => 'Public Speaking']);
        Skill::create(['skill_name' => 'Conflict Resolution']);

        Skill::create(['skill_name' => 'Community Service']);
        Skill::create(['skill_name' => 'Environmental Conservation']);
        Skill::create(['skill_name' => 'Social Advocacy']);
        Skill::create(['skill_name' => 'Fundraising']);
        Skill::create(['skill_name' => 'Volunteer Coordination']);
    }
}
