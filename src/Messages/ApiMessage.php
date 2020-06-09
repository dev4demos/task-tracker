<?php

declare (strict_types = 1);

namespace Task\Tracker\Messages;

use BadMethodCallException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Http\Request;
use Task\Tracker\Contracts\ApiContract;

abstract class ApiMessage
{
    /**
     * The message data.
     *
     * @var array
     */
    protected $links = array();

    /**
     * The message type.
     *
     * @var string
     */
    protected $type;

    /**
     * The message code.
     *
     * @var int
     */
    protected $code;

    /**
     * The message event. [insert, update, delete ...]
     *
     * @var string
     */
    protected $event;

    /**
     * The message description.
     *
     * @var string
     */
    protected $description;

    /**
     * @var Container
     */
    protected $ioc;

    /**
     * @param  Container  $ioc
     * @return void
     */
    public function __construct(Container $ioc)
    {
        $this->ioc = $ioc;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (string) json_encode($this->getPayload());
    }

    /**
     * @return mixed
     */
    public function getMeta(): array
    {
        $description = $this->getDescription();

        $event = $this->getEvent();

        $code = $this->getCode();

        return array_merge(get_defined_vars(), array(
            'root' => $this->ioc[Request::class]->root()
            // 'domain' => $this->ioc[Request::class]->getHost()
            // 'token' => $this->ioc[Session::class]->token()
        ));
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        $meta = $this->responding()->getMeta();

        return get_defined_vars();
    }

    /**
     * @param  string $key
     *
     * @return bool
     */
    public function hasLink(string $key): bool
    {
        return isset($this->links[$key]);
    }

    /**
     * @param  string $key
     * @param  string $link
     *
     * @return self
     */
    public function setLink(string $key, string $link): self
    {
        $this->links[$key] = $link;

        return $this;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param array $links
     *
     * @return self
     */
    public function setLinks(array $links): self
    {
        $this->links = array();

        foreach (array_intersect_key($links, $this->keyLinksFillable()) as $key => $link) {
            !$key || !$link ?: $this->setLink($key, $link);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function keyLinksFillable(): array
    {
        return array_flip($this->getLinksFillable());
    }

    /**
     * @return array
     */
    public function getLinksFillable(): array
    {
        return array('self', 'prev', 'next', 'last');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param  int $code
     *
     * @return self
     */
    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->translateDescription() ?: $this->description;
    }

    /**
     * @param  string $description
     *
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @param  string $event
     *
     * @return self
     */
    public function setEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @param string $event
     *
     * @return bool
     */
    public function isEvent(string $event): bool
    {
        return $this->event == strtolower($type);
    }

    /**
     * @return mixed
     */
    public function eventRespond()
    {
        $request = $this->ioc[Request::class];

        $this->hasLink('self') ?: $this->setLink(
            'self', $request->root() . '/' . $request->path()
        );

        if ($this->event && method_exists($this, $method = $this->event . 'Respond')) {
            return array($this, $method);
        }
    }

    /**
     * @return ApiContract
     */
    protected function responding(): ApiContract
    {
        if (is_callable($callback = $this->eventRespond())) {
            call_user_func($callback, $this);
        }

        return $this;
    }

    /**
     * @return ApiContract
     */
    protected function selectRespond(): ApiContract
    {
        // index
        return $this;
    }

    /**
     * @return ApiContract
     */
    protected function showRespond(): ApiContract
    {
        // delete/destroy
        return $this;
    }

    /**
     * @return ApiContract
     */
    protected function insertRespond(): ApiContract
    {
        // create
        return $this;
    }

    /**
     * @return ApiContract
     */
    protected function updateRespond(): ApiContract
    {
        // edit
        return $this;
    }

    /**
     * @return ApiContract
     */
    protected function deleteRespond(): ApiContract
    {
        // delete/destroy
        return $this;
    }

    /**
     * @return string
     */
    protected function translateDescription(): string
    {
        if ($translator = $this->ioc[Translator::class]) {
            // success or failure (SuccessMessage == success)
            $base = substr(strtolower(basename(get_called_class())), 0, -7);
            // tasks.select.success
            $keys = array(
                // tasks.select.success.404
                implode('.', array($this->getType(), $this->getEvent(), $base, $this->getCode())),
                // tasks.select.success
                implode('.', array($this->getType(), $this->getEvent(), $base))
            );

            foreach ($keys as $value) {
                $name = 'tracker::' . $value;

                if (($text = $translator->get($name)) != $name) {
                    return $text;
                }
            }
        }

        return '';
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array   $params
     *
     * @return mixed
     */
    public function __call($method, array $params = array())
    {
        $func = strtolower($method);

        if (substr($func, -5) == 'event') {
            return $this->setEvent(substr($func, 0, -5));
        }

        throw new BadMethodCallException(sprintf('Method %s::%s does not exist.', get_called_class(), $method));
    }
}
