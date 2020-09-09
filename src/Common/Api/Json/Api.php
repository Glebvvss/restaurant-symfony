<?php

namespace App\Common\Api\Json;

use App\Common\Api\Contract\ApiInterface;
use App\Common\Api\Contract\ApiRequestInterface;

class Api implements ApiInterface
{
    public function makeRequest(callable $callback): ApiRequestInterface
    {
        return new ApiRequest($callback);
    }
}