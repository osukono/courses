<?php

namespace App;

use App\Repositories\FieldRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Field
 *
 * @property int $id
 * @property int $data_type_id
 * @property string $identifier
 * @property string $name
 * @property bool $translatable
 * @property bool $audible
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\DataType $dataType
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field whereAudible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field whereDataTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field whereTranslatable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Field whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Field extends Model
{

    protected $casts = [
        'translatable' => 'boolean',
        'audible' => 'boolean'
    ];

    /**
     * @return BelongsTo|DataType
     */
    public function dataType()
    {
        return $this->belongsTo(DataType::class);
    }

    /** @var FieldRepository */
    private $repository;

    /**
     * @return FieldRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new FieldRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered($query) {
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
