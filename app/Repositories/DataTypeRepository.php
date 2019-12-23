<?php

namespace App\Repositories;

use App\DataType;
use Illuminate\Database\Eloquent\Builder;

class DataTypeRepository
{
    /** @var DataType $model */
    protected $model;

    public function __construct(DataType $dataType)
    {
        $this->model = $dataType;
    }

    /**
     * @param $id
     * @return DataTypeRepository
     */
    public static function find($id)
    {
        return DataType::findOrFail($id)->repository();
    }

    /**
     * @return Builder|DataType
     */
    public static function all()
    {
        return DataType::query();
    }

    /**
     * @return DataType
     */
    public function model()
    {
        return $this->model;
    }
}