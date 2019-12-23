<?php

namespace App;

use App\Repositories\DataTypeRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\DataType
 *
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataType ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DataType extends Model
{
    const string = 'string';
    const text = 'text';
    const audio = 'audio';
    const picture = 'picture';

    const rules = [
        DataType::string => 'bail|nullable|string|max:500',
        DataType::text => 'bail|nullable|string|max:5000',
        DataType::audio => 'bail|nullable|file|max:20480|mimes:wav,audio/mp3,mpga',
        DataType::picture => 'bail|nullable|file|max:1024|mimes:png'
    ];

    protected $fillable = [
        'type'
    ];


    /** @var DataTypeRepository */
    private $repository;

    /**
     * @return DataTypeRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new DataTypeRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('type');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->type;
    }
}
