<?php

namespace App\Repositories;

use App\Field;
use Illuminate\Database\Eloquent\Builder;

class FieldRepository
{
    /** @var Field $model */
    protected $model;

    public function __construct(Field $templateData)
    {
        $this->model = $templateData;
    }

    /**
     * @param $id
     * @return FieldRepository
     */
    public static function find($id)
    {
        return Field::findOrFail($id)->repository();
    }

    /**
     * @return Field|Builder
     */
    public static function all()
    {
        return Field::query();
    }

    /**
     * @param array $attributes
     * @return Field
     */
    public static function create(array $attributes)
    {
        $field = new Field();
        $field->dataType()->associate($attributes['data_type_id']);
        $field->name = $attributes['name'];
        $field->identifier = $attributes['identifier'];
        $field->translatable = isset($attributes['translatable']);
        $field->audible = isset($attributes['audible']);
        $field->save();

        return $field;
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->dataType()->associate($attributes['data_type_id']);
        $this->model->name = $attributes['name'];
        $this->model->identifier = $attributes['identifier'];
        $this->model->translatable = isset($attributes['translatable']);
        $this->model->audible = isset($attributes['audible']);
        $this->model->save();
    }

    /**
     * @return Field
     */
    public function model()
    {
        return $this->model;
    }
}
