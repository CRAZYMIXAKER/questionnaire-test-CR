<?php

namespace App\Http\Requests\Answer;

use App\Rules\ValidAnswer;
use Illuminate\Foundation\Http\FormRequest;

class StoreTemporaryAnswerRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'survey_id' => ['required', 'int'],
            'question_id' => ['required', 'int'],
            'answer' => ['required', new ValidAnswer()],
        ];
    }

}
