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
    public static function all(): AppLocale|Builder
    {
        return AppLocale::query();
    }

    /**
     * @param array $attributes
     * @return AppLocale
     */
    public static function create(array $attributes): AppLocale
    {
        $appLocale = new AppLocale();
        $appLocale->key = $attributes['key'];
        $appLocale->description = $attributes['description'];
        $appLocale->locale_group_id = $attributes['locale_group_id'];
        $appLocale->values = array_filter($attributes['locale'], function ($value) {
            return $value != null;
        });
        $appLocale->save();

        return $appLocale;
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
    public function model(): AppLocale
    {
        return $this->model;
    }
}
