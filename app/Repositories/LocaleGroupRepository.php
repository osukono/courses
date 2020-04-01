<?php


namespace App\Repositories;


use App\LocaleGroup;
use Illuminate\Database\Eloquent\Builder;

class LocaleGroupRepository
{
    private LocaleGroup $model;

    public function __construct(LocaleGroup $localeGroup)
    {
        $this->model = $localeGroup;
    }

    /**
     * @return Builder|LocaleGroup
     */
    public static function all()
    {
        return LocaleGroup::query();
    }

    /**
     * @param array $attributes
     * @return LocaleGroup
     */
    public static function create(array $attributes)
    {
        $localeGroup = new LocaleGroup();

        $localeGroup->name = $attributes['name'];
        $localeGroup->save();

        return $localeGroup;
    }

    public function update(array $attributes)
    {
        $this->model->name = $attributes['name'];
        $this->model->save();
    }

    /**
     * @return LocaleGroup
     */
    public function model()
    {
        return $this->model;
    }
}
