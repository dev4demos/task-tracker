<?php

declare (strict_types = 1);

namespace Task\Tracker\Messages;

use Exception;
use Task\Tracker\Contracts\ApiContract;
use Task\Tracker\Contracts\ApiErrorContract;

class FailureMessage extends ApiMessage implements ApiErrorContract
{
    /**
     * {@inheritdoc }
     */
    protected $code = ApiContract::HTTP_NOT_FOUND;

    /**
     * {@inheritdoc }
     */
    protected $description = 'failure';

    /**
     * @var Exception
     */
    protected $exception;

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $errors = array();

        if ($exception = $this->getException()) {
            $errors[] = $exception->getCode();
        }

        return $errors;
    }

    /**
     * @return Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     *
     * @return self
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;

        return $this;
    }
}
