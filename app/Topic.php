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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Topic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Topic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Topic ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Topic query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Topic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Topic whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Topic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Topic whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Topic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Topic whereUpdatedAt($value)
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
