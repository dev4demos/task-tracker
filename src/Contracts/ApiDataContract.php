<?php

declare (strict_types = 1);

namespace Task\Tracker\Contracts;

interface ApiDataContract extends ApiContract
{
    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return array
     */
    public function getLinks(): array;

    /**
     * @return array
     */
    // public function getForms(): array;
}
