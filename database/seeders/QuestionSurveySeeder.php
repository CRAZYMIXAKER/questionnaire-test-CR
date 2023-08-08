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
            $existingQuestionIds = QuestionSurvey::where(
                'survey_id',
                $survey->id
            )->pluck('question_id')->toArray();

            for ($i = 0; $i < 3; $i++) {
                do {
                    $randomQuestionId = Question::where('parent_id', null)
                        ->inRandomOrder()
                        ->value('id');
                } while (in_array($randomQuestionId, $existingQuestionIds));

                QuestionSurvey::create([
                    'question_id' => $randomQuestionId,
                    'survey_id' => $survey->id,
                ]);

                $existingQuestionIds[] = $randomQuestionId; // Добавляем сгенерированный question_id в массив, чтобы следующие итерации не дублировали его
            }
        }
    }

}
