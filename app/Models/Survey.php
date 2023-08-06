<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Survey extends Model
{

    use HasFactory;

    protected $table = 'surveys';

    protected $fillable = ['title'];

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(
            Question::class,
            'question_surveys',
        );
    }

}
