<?php

declare (strict_types = 1);

namespace Task\Tracker\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model
{
    /**
     * Get the task user in as single query.
     *
     * @param  mixed $subs
     *
     * @return Builder
     */
    public static function apiQuery(...$subs): Builder
    {
        return static::query();
    }

    /**
     * Get the task user in as single query.
     *
     * @param  mixed $param
     *
     * @return Builder
     */
    public static function searchQuery($param): Builder
    {
        $query = static::query();

        // get where key
        if (is_scalar($param)) {
            return $query->where($query->getModel()->getKeyName(), $param);
        }
        // get where ['name'=>'doe', 'email'=>'doe@gmail.com', ...]
        elseif (is_array($param) && is_array($current = current($param))) {
            $param = $current;
        } else {
            $param = (array) $param;
        }
        // where
        foreach ($param as $param => $value) {
            if (!$query->getModel()->isFillable($param)) {
                continue;
            }
            $query->where($param, $value);
        }

        return $query;
    }
}
