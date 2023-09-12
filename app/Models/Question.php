<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $fillable = [
        'text',
        'type',
        'parent_id',
    ];

    /**
     * @return HasMany
     */
    public function nestings(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function surveys(): BelongsToMany
    {
        return $this->belongsToMany(
            Survey::class,
            'question_surveys',
            'question_id',
            'survey_id'
        );
    }
}
