<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::all();

        return response()->json($questions);
    }

}
