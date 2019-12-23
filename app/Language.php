<?php

namespace App;

use App\Repositories\LanguageRepository;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Language
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $editors
 * @property-read int|null $editors_count
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereSlug($value)
 */
class Language extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'code'
    ];

    /**
     * @return MorphToMany|User
     */
    public function editors()
    {
        return $this->morphToMany(User::class, 'accessible');
    }

    /** @var LanguageRepository */
    private $repository;

    /**
     * @return LanguageRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new LanguageRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }

    /**
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['code']
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function __toString()
    {
        return $this->name;
    }
}
