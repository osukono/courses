<?php

namespace App;

use App\Repositories\TopicRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Topic
 *
 * @property int $id
 * @property string $identifier
 * @property string $name
 * @property string|null $firebase_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Topic newModelQuery()
 * @method static Builder|Topic newQuery()
 * @method static Builder|Topic ordered()
 * @method static Builder|Topic query()
 * @method static Builder|Topic whereCreatedAt($value)
 * @method static Builder|Topic whereFirebaseId($value)
 * @method static Builder|Topic whereId($value)
 * @method static Builder|Topic whereIdentifier($value)
 * @method static Builder|Topic whereName($value)
 * @method static Builder|Topic whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Topic extends Model
{

    private TopicRepository $repository;

    /**
     * @return TopicRepository
     */
    public function repository()
    {
        return $this->repository ?? $this->repository = new TopicRepository($this);
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
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
