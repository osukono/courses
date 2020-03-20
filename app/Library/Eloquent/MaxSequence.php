<?php


namespace App\Library\Eloquent;


use Illuminate\Database\Eloquent\Builder;

trait MaxSequence
{
    /**
     * @return int
     */
    public function maxSequence()
    {
        return $this->where(function(Builder $query) {
            // ToDo group can be an array
            foreach ((array) $this->sequence()['group'] as $group)
                $query->where($group, $this->{$group});
        })->max($this->sequence()['fieldName']);
    }
}
