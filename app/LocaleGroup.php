<?php

namespace App;

use App\Repositories\LocaleGroupRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\LocaleGroup
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AppLocale[] $locales
 * @property-read int|null $locales_count
 * @method static Builder|LocaleGroup newModelQuery()
 * @method static Builder|LocaleGroup newQuery()
 * @method static Builder|LocaleGroup ordered()
 * @method static Builder|LocaleGroup query()
 * @method static Builder|LocaleGroup whereCreatedAt($value)
 * @method static Builder|LocaleGroup whereId($value)
 * @method static Builder|LocaleGroup whereName($value)
 * @method static Builder|LocaleGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LocaleGroup extends Model
{
    /**
     * @return HasMany|AppLocale
     */
    public function locales()
    {
        return $this->hasMany(AppLocale::class);
    }

    private LocaleGroupRepository $repository;

    /**
     * @return LocaleGroupRepository
     */
    public function repository()
    {
        return $this->repository ?? $this->repository = new LocaleGroupRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }

    public function __toString()
    {
        return $this->name;
    }
}
