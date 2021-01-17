<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\LessonImage
 *
 * @property int $id
 * @property int $lesson_id
 * @property int $language_id
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LessonImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonImage whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonImage whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessonImage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Language $language
 * @property-read \App\Lesson $lesson
 */
class LessonImage extends Model
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
