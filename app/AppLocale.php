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
 * @method static Builder|AppLocale newModelQuery()
 * @method static Builder|AppLocale newQuery()
 * @method static Builder|AppLocale ordered()
 * @method static Builder|AppLocale query()
 * @method static Builder|AppLocale whereCreatedAt($value)
 * @method static Builder|AppLocale whereDescription($value)
 * @method static Builder|AppLocale whereId($value)
 * @method static Builder|AppLocale whereKey($value)
 * @method static Builder|AppLocale whereLocaleGroupId($value)
 * @method static Builder|AppLocale whereUpdatedAt($value)
 * @method static Builder|AppLocale whereValues($value)
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
        return $this->repository ?? $this->repository = new AppLocaleRepository($this);
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
