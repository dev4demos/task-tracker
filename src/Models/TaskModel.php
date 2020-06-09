<?php

declare (strict_types = 1);

namespace Task\Tracker\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class TaskModel extends AbstractModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable. [active/completed]
     *
     * @var array
     */
    protected $fillable = array(
        'user_id', 'title', 'description', 'status'
    );

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    // protected $with = array('user');

    /**
     * Get the user that owns the task.
     *
     * @return Relation
     */
    public function user(): Relation
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    /**
     * Get the task user in as single query.
     *
     * @param  mixed $subs
     *
     * @return Builder
     */
    public static function apiQuery(...$subs): Builder
    {
        !is_array(current($subs)) ?: $subs = array_shift($subs);

        $user = new UserModel;

        $subs = array_flip($subs ?: $user->getFillable());

        foreach ($subs as $col => $nop) {
            if (!$user->isFillable($col)) {
                continue;
            }

            $subs[$col] = $user->select($col)->whereColumn($user->getQualifiedKeyName(), 'user_id');
        }

        return static::query()->addSelect($subs);
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
        $query = parent::searchQuery($param);

        if (is_array($param)) {
            $current = current($param);

            !is_array($current) ?: $param = $current;

            $target = new UserModel;

            // where
            foreach ($param as $param => $value) {
                if (!$target->isFillable($param)) {
                    continue;
                }

                $query->whereIn('user_id', function ($sub) use ($target, $param, $value) {
                    $sub->select($target->getQualifiedKeyName())->from($target->getTable())->where($param, $value);
                });
            }
        }

        return $query;
    }
}
