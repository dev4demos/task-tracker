<?php

declare (strict_types = 1);

namespace Task\Tracker\Messages;

use Illuminate\Database\Eloquent\Model;
use Task\Tracker\Contracts\ApiContract;
use Task\Tracker\Contracts\ApiDataContract;

class SuccessMessage extends ApiMessage implements ApiDataContract
{
    /**
     * @var Model
     */
    protected $item;

    /**
     * The message data.
     *
     * @var array
     */
    protected $data = array();

    /**
     * {@inheritdoc }
     */
    protected $code = ApiContract::HTTP_OK;

    /**
     * {@inheritdoc }
     */
    protected $description = 'success';

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type ?: $this->getItem()->getTable();
    }

    /**
     * @return Model
     */
    public function getItem(): Model
    {
        return $this->item;
    }

    /**
     * @return boolean
     */
    public function hasItem(): bool
    {
        return $this->item ? true : false;
    }

    /**
     * @param Model $item
     *
     * @return self
     */
    public function setItem(Model $item): self
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        $meta = $this->responding()->getMeta();

        $links = $this->getLinks();

        $data = $this->getData();

        return get_defined_vars();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param  array $rows
     *
     * @return array
     */
    protected function transformData(array $rows): array
    {
        $me = $this;

        $callback = function ($row) use ($me) {
            $key = $me->getItem()->getKeyName();

            return array(
                'id' => isset($row[$key]) ? $row[$key] : null,
                'type' => $me->getType(),
                'attributes' => $row
            );
        };

        foreach ($rows as $key => $row) {
            $rows[$key] = $callback($row);
        }

        return $rows;
    }

    /**
     * @param  mixed $item
     *
     * @return array
     */
    protected function transformItem($item): array
    {
        $data = array();

        if ($item instanceof Model && ($data = $item->toArray())) {
            $data = current($this->transformData(array($data)));
        }

        return $data;
    }

    /**
     * @return ApiContract
     */
    protected function selectRespond(): ApiContract
    {
        $this->setData($this->transformData($this->getData()));

        // index
        return $this;
    }

    /**
     * @return ApiContract
     */
    protected function showRespond(): ApiContract
    {
        if ($item = $this->transformItem($this->getItem())) {
            $this->setData($item);
        }

        return $this;
    }

    /**
     * @return ApiContract
     */
    protected function insertRespond(): ApiContract
    {
        if ($item = $this->transformItem($this->getItem())) {
            $this->setData($item);
        }

        return $this;
    }

    /**
     * @return ApiContract
     */
    protected function updateRespond(): ApiContract
    {
        if ($item = $this->transformItem($this->getItem())) {
            $this->setData($item);
        }

        return $this;
    }
}
