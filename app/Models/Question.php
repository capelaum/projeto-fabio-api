<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'discipline_id',
        'category_id',
        'title',
        'content',
        'year',
        'image_url',
        'is_active',
    ];

    public function discipline(): BelongsTo
    {
        return $this->belongsTo(Discipline::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function alternatives(): HasMany
    {
        return $this->hasMany(Alternative::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(QuestionLink::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

    public function answeredQuestions(): HasMany
    {
        return $this->hasMany(AnsweredQuestion::class);
    }
}
