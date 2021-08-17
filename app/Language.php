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
 * @property string|null $locale
 * @property string|null $icon
 * @property string $slug
 * @property string|null $capitalized_words
 * @property string|null $firebase_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $editors
 * @property-read int|null $editors_count
 * @property-read \App\PlayerSettings|null $playerSettings
 * @method static Builder|Language findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static Builder|Language hasAccess(\App\User $user)
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language ordered()
 * @method static Builder|Language query()
 * @method static Builder|Language whereCapitalizedWords($value)
 * @method static Builder|Language whereCode($value)
 * @method static Builder|Language whereCreatedAt($value)
 * @method static Builder|Language whereFirebaseId($value)
 * @method static Builder|Language whereIcon($value)
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language whereLocale($value)
 * @method static Builder|Language whereName($value)
 * @method static Builder|Language whereNative($value)
 * @method static Builder|Language whereSlug($value)
 * @method static Builder|Language whereUpdatedAt($value)
 * @method static Builder|Language withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @mixin \Eloquent
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
        return $this->repository ?? $this->repository = new LanguageRepository($this);
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

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeHasAccess(Builder $query, User $user)
    {
        return $user->isAdmin() ? $query : $query->whereHas('editors', function (Builder $query) use ($user) {
            $query->where('id', $user->id);
        });
    }

    public function __toString()
    {
        return $this->name;
    }
}
