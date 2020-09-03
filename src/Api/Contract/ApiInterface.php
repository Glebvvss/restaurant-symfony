<?php

namespace App\Api\Contract;

interface ApiInterface
{
    public function makeRequest(callable $callback): ApiRequestInterface;
}