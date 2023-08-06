<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            ['text' => 'Question 1', 'type' => 'textarea'],
            ['text' => 'Question 2', 'type' => 'textarea'],
            ['text' => 'Question 3', 'type' => 'textarea'],
            [
                'text' => 'Question 4',
                'type' => 'select',
                'nestings' => [
                    ['text' => 'Question 4 / Select 1'],
                    ['text' => 'Question 4 / Select 2'],
                    ['text' => 'Question 4 / Select 3'],
                ],
            ],
            [
                'text' => 'Question 5',
                'type' => 'subquestion',
                'nestings' => [
                    ['text' => 'Question 5 / Subquestion 1'],
                    ['text' => 'Question 5 / Subquestion 2'],
                    ['text' => 'Question 5 / Subquestion 3'],
                ],
            ],
        ];

        foreach ($questions as $question) {
            if (Question::where('text', $question['text'])->doesntExist()) {
                $newQuestion = Question::create([
                    'text' => $question['text'],
                    'type' => $question['type'],
                ]);

                if (isset($question['nestings'])) {
                    foreach ($question['nestings'] as $nesting) {
                        Question::create([
                                'text' => $nesting['text'],
                                'type' => $newQuestion->type,
                                'parent_id' => $newQuestion->id,
                            ]
                        );
                    }
                }
            }
        }
    }

}
