<?php

namespace App\Http\Controllers\Api;

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
