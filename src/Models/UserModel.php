<?php

declare (strict_types = 1);

namespace Task\Tracker\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class UserModel extends AbstractModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'name', 'email', 'password', 'user_role', 'email_verified_at'
    );

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = array(
        'password', 'remember_token'
    );

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = array(
        'email_verified_at' => 'datetime'
    );

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    // protected $with = array('tasks');

    /**
     * Get the tasks for this user.
     *
     * @return Relation
     */
    public function tasks(): Relation
    {
        return $this->hasMany(TaskModel::class, 'user_id');
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

            $target = new TaskModel;
            // where
            foreach ($param as $param => $value) {
                if (!$target->isFillable($param)) {
                    continue;
                }

                $query->whereIn($query->getModel()->getKeyName(), function ($sub) use ($target, $param, $value) {
                    $sub->select('user_id')->from($target->getTable())->where($param, $value);
                });
            }
        }

        return $query;
    }
}
