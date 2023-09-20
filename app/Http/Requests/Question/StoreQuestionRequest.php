<?php

namespace App\Http\Requests\Question;

use App\Rules\IntOrNull;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'text'            => ['required', 'string', 'max:255'],
            'type'            => ['required', 'in:textarea,select,subquestion'],
            'parent_id'       => ['nullable', 'integer'],
            'nestings'        => ['array'],
            'nestings.*.text' => ['string'],
        ];
    }
}
