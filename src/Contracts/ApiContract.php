<?php

declare (strict_types = 1);

namespace Task\Tracker\Contracts;

interface ApiContract
{
    /**
     * The http success response code
     * https://jsonapi.org/format/#crud-updating-relationship-responses
     * 200 OK
     *
     * @return int
     */
    const HTTP_OK = 200;

    /**
     * https://jsonapi.org/format/#crud-updating-relationship-responses
     * 201 Created
     *
     * @return int
     */
    const HTTP_CREATED = 201;

    /**
     * https://jsonapi.org/format/#crud-updating-relationship-responses
     * 202 Accepted
     *
     * @return int
     */
    const HTTP_ACCEPTED = 202;

    /**
     * https://jsonapi.org/format/#crud-updating-relationship-responses
     * 403 Forbidden
     *
     * @return int
     */
    // const HTTP_FORBIDDEN = 403;

    /**
     * https://jsonapi.org/format/#crud-updating-relationship-responses
     * 404 NOT FOUND
     *
     * @return int
     */
    const HTTP_NOT_FOUND = 404;

    /**
     * @return array
     */
    public function getMeta(): array;

    /**
     * @return array
     */
    public function getPayload(): array;

    /**
     * @return array
     */
    public function getLinks(): array;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return int
     */
    public function getCode(): int;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getEvent(): string;
}
