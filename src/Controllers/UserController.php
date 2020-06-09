<?php

declare (strict_types = 1);

namespace Task\Tracker\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Task\Tracker\Models\UserModel;

class UserController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->actionIndex();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return $this->actionStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        return $this->actionShow($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        return $this->actionUpdate($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->actionDestroy($id);
    }

    /**
     * @return mixed
     */
    public function model(): Model
    {
        /**
         * @var mixed
         */
        static $instance;

        return $instance ?: $instance = new UserModel;
    }

    /**
     * @return Builder
     */
    public function modelQuery(): Builder
    {
        return $this->model()->query();
    }

    /**
     * @return array
     */
    public function subAttributes(): array
    {
        return array();
    }
}
