<?php


namespace App\Repositories;


use App\Level;
use Illuminate\Database\Eloquent\Builder;

class LevelRepository
{
    /** @var Level $model */
    protected $model;

    /**
     * LevelRepository constructor.
     * @param Level $level
     */
    public function __construct(Level $level)
    {
        $this->model = $level;
    }

    /**
     * @param $id
     * @return LevelRepository
     */
    public static function find($id)
    {
        return Level::findOrFail($id)->repository();
    }

    /**
     * @return Builder|Level
     */
    public static function all()
    {
        return Level::query();
    }

    /**
     * @return Level
     */
    public function model()
    {
        return $this->model;
    }
}