<?php

namespace App\Api\Json;

use App\Api\Contract\ApiInterface;
use App\Api\Contract\ApiRequestInterface;

class Api implements ApiInterface
{
    public function makeRequest(callable $callback): ApiRequestInterface
    {
        return new ApiRequest($callback);
    }
}