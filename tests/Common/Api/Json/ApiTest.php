<?php

namespace App\Test\Common\Api\Json;

use App\Common\Api\Json\Api;
use App\Common\Api\Json\ApiRequest;
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