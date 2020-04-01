<?php

namespace App;

use App\Repositories\AppLocaleRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\AppLocale
 *
 * @property int $id
 * @property int|null $locale_group_id
 * @property string|null $description
 * @property string $key
 * @property array $values
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\LocaleGroup|null $localeGroup
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale whereLocaleGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppLocale whereValues($value)
 * @mixin \Eloquent
 */
class AppLocale extends Model
{
    protected $casts = [
        'values' => 'array'
    ];

    /**
     * @return BelongsTo|LocaleGroup
     */
    public function localeGroup()
    {
        return $this->belongsTo(LocaleGroup::class);
    }

    private AppLocaleRepository $repository;

    /**
     * @return AppLocaleRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new AppLocaleRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered($query)
    {
        return $query->leftJoin('locale_groups', 'app_locales.locale_group_id', '=', 'locale_groups.id')
            ->orderBy('locale_groups.name')
            ->orderBy('key')
            ->select('app_locales.*');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->key;
    }
}
