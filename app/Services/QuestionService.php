<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuestionService
{
    /**
     * @param  int  $questionId
     *
     * @return mixed
     */
    private function findQuestion(int $questionId): mixed
    {
        return Question::findOrFail($questionId);
    }

    /**
     * @param  int  $questionId
     *
     * @return \App\Http\Resources\QuestionResource
     */
    public function getQuestion(int $questionId): QuestionResource
    {
        $question = $this->findQuestion($questionId);
        $question->load('nestings');

        return new QuestionResource($question);
    }

    /**
     * @param  int  $surveyId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \App\Exceptions\NotFoundException
     */
    public function getNotSurveyQuestions(int $surveyId): LengthAwarePaginator
    {
        return Question::whereDoesntHave(
            'surveys',
            function ($query) use ($surveyId) {
                $query->where('survey_id', $surveyId);
            }
        )
            ->where('parent_id', '=', null)
            ->paginate(10);
    }

    /**
     * @param  int  $surveyId
     *
     * @return void
     */
    public function deleteQuestion(int $surveyId): void
    {
        $survey = $this->findQuestion($surveyId);
        $survey->delete();
    }

    public function checkQuestionType($questionId)
    {
    }

    /**
     * @param  string  $text
     * @param  string  $type
     * @param  int  $parent_id
     *
     * @return void
     * @throws \App\Exceptions\NotFoundException
     */
    public function storeNestingQuestion(
        string $text,
        string $type,
        int    $parent_id,
    ): void {
        try {
            Question::findOrFail($parent_id);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException(
                "Question with this parent id has not been found"
            );
        }

        Question::create([
            'text' => $text,
            'type' => $type,
            'parent_id' => $parent_id,
        ]);
    }

    /**
     * @param  array  $data
     *
     * @return void
     * @throws \App\Exceptions\NotFoundException
     */
    public function updateQuestion(array $data): void
    {
        try {
            $question = Question::findOrFail($data['id']);
            $question->update($data);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException(
                "Question with this id has not been found"
            );
        }
    }

    /**
     * @param  int  $id
     * @param  string  $type
     *
     * @return void
     * @throws \App\Exceptions\NotFoundException
     */
    public function updateQuestionType(int $id, string $type): void
    {
        try {
            $question = Question::findOrFail($id);
            $question->update(['type' => $type]);
            Question::where('parent_id', $id)->delete();
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException(
                "Question with this id has not been found"
            );
        }
    }
}
