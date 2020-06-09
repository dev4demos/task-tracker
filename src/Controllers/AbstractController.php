<?php

declare (strict_types = 1);

namespace Task\Tracker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Task\Tracker\Contracts\ApiContract;
use Task\Tracker\Messages\FailureMessage;
use Task\Tracker\Messages\SuccessMessage;

abstract class AbstractController extends Controller
{
    /**
     * The pagination count.
     *
     * @var int
     */
    protected $show = 10;

    /**
     * @var Container
     */
    protected $ioc;

    /**
     * The API message.
     *
     * @var ApiContract
     */
    protected $message;

    /**
     * @param  Container  $ioc
     * @return void
     */
    public function __construct(Container $ioc)
    {
        $this->ioc = $ioc;
    }

    /**
     * @return Model
     */
    abstract public function model(): Model;

    /**
     * @return Builder
     */
    abstract public function modelQuery(): Builder;

    /**
     * @return array
     */
    abstract public function subAttributes(): array;

    /**
     * @return array
     */
    public function qryAttributes(): array
    {
        return $this->model()->getFillable();
    }

    /**
     * @return array
     */
    public function apiAttributes(): array
    {
        return array_merge($this->qryAttributes(), $this->subAttributes());
    }

    /**
     * The message responds as JSON.
     *
     * @return JsonResponse
     */
    public function respond(): JsonResponse
    {
        $message = $this->message;

        if ($message instanceof SuccessMessage) {
            // we need a model to expose the fillable(form) API attributes
            $message->hasItem() ?: $message->setItem($this->model());
        }

        return $this->ioc[ResponseFactory::class]->json($message->getPayload());
    }

    /**
     * @param string $description
     *
     * @return self
     */
    public function failure($description): self
    {
        return $this->setMessage($this->ioc[FailureMessage::class]->setDescription($description));
    }

    /**
     * @param string $description
     *
     * @return self
     */
    public function success($description): self
    {
        return $this->setMessage($this->ioc[SuccessMessage::class]->setDescription($description));
    }

    /**
     * @return ApiContract
     */
    public function getMessage(): ApiContract
    {
        return $this->message;
    }

    /**
     * @param ApiContract $message
     *
     * @return self
     */
    public function setMessage(ApiContract $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return int
     */
    public function getShow(): int
    {
        return $this->show;
    }

    /**
     * @param  int $show
     *
     * @return self
     */
    public function setShow(int $show): self
    {
        $this->show = $show;

        return $this;
    }

    /**
     * Search api filter with pagination
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search($param = null): JsonResponse
    {
        $request = $this->ioc[Request::class];

        $query = $this->model()->searchQuery(
            $param ?: $request->input('search') ?: $request->input()
        );

        return $this->success(__FUNCTION__)->pagerQuery($query)->respond();
    }

    /**
     * @return self
     */
    protected function pagerQuery(Builder $query): self
    {
        $request = $this->ioc[Request::class];

        $show = (int) $request->input('show', $this->getShow() ?: 10);

        $appends = $request->is('*search*') ? $request->input() : compact('show');

        $pager = $query->paginate($show)->appends((array) $appends);

        $data = $pager->getCollection()->toArray();

        $this->getMessage()->selectEvent()->setData($data)->setLinks(array(
            'self' => $pager->url($pager->currentPage()),
            'prev' => $pager->previousPageUrl(),
            'next' => $pager->hasMorePages() ? $pager->nextPageUrl() : null,
            'last' => !$pager->hasPages() ? null : $pager->url($pager->lastPage())
        ));

        return $this;
    }

    /**
     * @param  string $name
     *
     * @return string
     */
    protected function actionName(string $name): string
    {
        return strtolower(trim($name, 'action'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function actionIndex(): JsonResponse
    {
        // dd($this->ioc['router']);

        // $request = $this->ioc[Request::class];
        // return $this->actionStore($request, 0);

        return $this->success($this->actionName(__FUNCTION__))->pagerQuery($this->modelQuery())->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function actionStore(Request $request = null): JsonResponse
    {
        $name = $this->actionName(__FUNCTION__);

        $data = ($request ?: $this->ioc[Request::class])->input('attributes', array());

        // validate data

        try {
            $item = $this->model()->create($data);
            // success message
            $message = $this->success($name)->getMessage();

            if ($item) {
                $message->setCode(ApiContract::HTTP_CREATED)->setItem($item);
            }
        } catch (\Exception $error) {
            // failure message
            $this->failure($name);
        } finally {
            $this->getMessage()->insertEvent();
        }

        return $this->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function actionShow($id): JsonResponse
    {
        $name = $this->actionName(__FUNCTION__);

        try {
            // $item = $this->model()->findOrFail($id);
            $item = $this->modelQuery()->where($this->model()->getKeyName(), $id)->first();
            // success message
            $message = $this->success($name)->getMessage();

            if ($item) {
                $message->setCode(ApiContract::HTTP_CREATED)->setItem($item);
            } else {
                $message->setCode(ApiContract::HTTP_NOT_FOUND);
            }
        } catch (\Exception $error) {
            // failure message
            $this->failure($name);
        } finally {
            $this->getMessage()->showEvent();
        }

        return $this->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function actionUpdate($id, Request $request = null): JsonResponse
    {
        $name = $this->actionName(__FUNCTION__);

        $data = ($request ?: $this->ioc[Request::class])->input('attributes', array());

        // validate data

        try {
            $item = $this->model()->find((int) $request->input('id', $id));
            // success fetch
            $message = $this->success($name)->getMessage();

            if (!$item || !$item->fill($data)->save()) {
                $message->setCode(ApiContract::HTTP_NOT_FOUND);
            } else {
                $message->setItem($item);
            }
        } catch (\Exception $error) {
            // failure fetch
            $this->failure($name);
        } finally {
            $this->getMessage()->updateEvent();
        }

        return $this->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function actionDestroy($id): JsonResponse
    {
        $name = $this->actionName(__FUNCTION__);

        try {
            $count = $this->model()->destroy($id);

            $this->success($name);

            $count ?: $this->getMessage()->setCode(ApiContract::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            $this->failure($name);
        } finally {
            $this->getMessage()->deleteEvent();
        }

        return $this->respond();
    }
}
