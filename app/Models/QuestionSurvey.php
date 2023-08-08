<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSurvey extends Model
{
    use HasFactory;

    protected $table = 'question_surveys';

    protected $fillable = [
        'question_id',
        'survey_id',
    ];
}
