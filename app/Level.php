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
 * @method static Builder|Level newModelQuery()
 * @method static Builder|Level newQuery()
 * @method static Builder|Level ordered()
 * @method static Builder|Level query()
 * @method static Builder|Level whereCreatedAt($value)
 * @method static Builder|Level whereId($value)
 * @method static Builder|Level whereName($value)
 * @method static Builder|Level whereScale($value)
 * @method static Builder|Level whereUpdatedAt($value)
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
