<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\LessonProperty
 *
 * @property int $id
 * @property int $lesson_id
 * @property int $language_id
 * @property string|null $image
 * @property string|null $grammar_point
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Language $language
 * @property-read \App\Lesson $lesson
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProperty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProperty whereGrammarPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProperty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProperty whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProperty whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProperty whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProperty whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LessonProperty extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * @return BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
