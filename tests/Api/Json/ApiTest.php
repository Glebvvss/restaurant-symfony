<?php

namespace App\Test\Api\Json;

use App\Api\Json\Api;
use App\Api\Json\ApiRequest;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    public function test_makeRequest()
    {
        $callback = fn() => ['result'];
        $api = new Api();
        $this->assertEquals(
            new ApiRequest($callback),
            $api->makeRequest($callback)
        );
    }
}