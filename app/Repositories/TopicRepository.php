<?php


namespace App\Repositories;


use App\Topic;
use Illuminate\Database\Eloquent\Builder;

class TopicRepository
{
    private Topic $model;

    public function __construct(Topic $topic)
    {
        $this->model = $topic;
    }

    /**
     * @return Topic|Builder
     */
    public static function all()
    {
        return Topic::query();
    }

    /**
     * @param array $attributes
     * @return Topic
     */
    public static function create(array $attributes)
    {
        $topic = new Topic();
        $topic->name = $attributes['name'];
        $topic->identifier = $attributes['identifier'];
        $topic->save();

        return $topic;
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->name = $attributes['name'];
        $this->model->identifier = $attributes['identifier'];
        $this->model->firebase_id = $attributes['firebase_id'];

        $this->model->save();
    }

    /**
     * @return Topic
     */
    public function model()
    {
        return $this->model;
    }
}
