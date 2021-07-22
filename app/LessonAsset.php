<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\LessonAsset
 *
 * @property int $id
 * @property int $lesson_id
 * @property int $language_id
 * @property string|null $image
 * @property string|null $description
 * @property string|null $grammar_point
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Language $language
 * @property-read \App\Lesson $lesson
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset query()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset whereGrammarPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonAsset whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LessonAsset extends Model
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
