<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionSurvey;
use App\Models\Survey;
use Illuminate\Database\Seeder;

class QuestionSurveySeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Survey::all() as $survey) {
            for ($i = 0; $i < 3; $i++) {
                QuestionSurvey::create([
                    'question_id' => Question::where('parent_id', null)
                        ->inRandomOrder()
                        ->value('id'),
                    'survey_id' => $survey->id,
                ]);
            }
        }
    }

}
