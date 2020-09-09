<?php

namespace App\Common\Api\Contract;

interface ApiInterface
{
    public function makeRequest(callable $callback): ApiRequestInterface;
}