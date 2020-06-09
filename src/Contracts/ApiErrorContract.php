<?php

declare (strict_types = 1);

namespace Task\Tracker\Contracts;

interface ApiErrorContract extends ApiContract
{
    public function getErrors(): array;
}
