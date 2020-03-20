<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Level
 *
 * @property int $id
 * @property string $scale
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Level newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Level newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Level ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Level query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Level whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Level whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Level whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Level whereScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Level whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Level extends Model
{
    protected $fillable = [
        'name',
        'scale'
    ];

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered($query) {
        return $query->orderBy('scale');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
