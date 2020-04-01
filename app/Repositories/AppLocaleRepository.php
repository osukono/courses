<?php


namespace App\Repositories;


use App\AppLocale;
use Illuminate\Database\Eloquent\Builder;

class AppLocaleRepository
{
    private AppLocale $model;

    public function __construct(AppLocale $appLocale)
    {
        $this->model = $appLocale;
    }

    /**
     * @return AppLocale|Builder
     */
    public static function all()
    {
        return AppLocale::query();
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->key = $attributes['key'];
        $this->model->description = $attributes['description'];
        $this->model->locale_group_id = $attributes['locale_group_id'];
        $this->model->values = array_filter($attributes['locale'], function ($value) {
            return $value != null;
        });
        $this->model->save();
    }

    /**
     * @return AppLocale
     */
    public function model()
    {
        return $this->model;
    }
}
