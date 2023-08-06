<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    protected $fillable = [
        'survey_id',
        'question_id',
        'session_id',
        'user_id',
        'answer',
        'status',
    ];
}
