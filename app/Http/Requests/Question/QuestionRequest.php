<?php

namespace App\Http\Requests\Question;

use App\Rules\IntOrNull;
use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'id'        => ['required', 'int'],
            'text'      => ['max:255'],
            'type'      => ['MAX:255'],
            'parent_id' => [new IntOrNull()],
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => request()->id,
        ]);
    }
}
