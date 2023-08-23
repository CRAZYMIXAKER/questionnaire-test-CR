<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'text',
        'type',
        'parent_id',
    ];

    public function nestings()
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }
}
