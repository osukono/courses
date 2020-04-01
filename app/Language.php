<?php

namespace App;

use App\Repositories\LanguageRepository;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


/**
 * App\Language
 *
 * @property int $id
 * @property string $name
 * @property string $native
 * @property string $code
 * @property string|null $icon
 * @property string $slug
 * @property string|null $firebase_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $editors
 * @property-read int|null $editors_count
 * @property-read \App\PlayerSettings $playerSettings
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereNative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereLocale($value)
 */
class Language extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'native',
        'code'
    ];

    /**
     * @return MorphToMany|User
     */
    public function editors()
    {
        return $this->morphToMany(User::class, 'accessible');
    }

    /**
     * @return HasOne|PlayerSettings
     */
    public function playerSettings()
    {
        return $this->hasOne(PlayerSettings::class);
    }

    private LanguageRepository $repository;

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
        return $query->orderBy('native');
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
