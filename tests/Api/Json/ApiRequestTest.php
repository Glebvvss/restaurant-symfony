<?php

namespace App\Test\Api\Json;

use Exception;
use App\Api\Json\ApiRequest;
use PHPUnit\Framework\TestCase;
use App\Common\Exception\ErrorReporting;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiRequestTest extends TestCase
{
    public function test_buildResponse_ok()
    {
        $content = ['result' => 'success'];
        $request = new ApiRequest(fn() => $content);
        $this->assertEquals(
            $request->buildResponse(),
            new JsonResponse([
                'success' => 1,
                'data'    => $content
            ])
        );
    }

    public function test_buildResponse_errorReporting()
    {
        $error = 'Some error';

        $request = new ApiRequest(function() use ($error) {
            throw new ErrorReporting($error);
        });

        $this->assertEquals(
            $request->buildResponse(),
            new JsonResponse([
                'success' => 0,
                'error'   => $error
            ])
        );
    }

    public function test_buildResponse_unknownError()
    {
        $request = new ApiRequest(function() {
            throw new Exception('');
        });

        $this->assertEquals(
            $request->buildResponse(),
            new JsonResponse([
                'success' => 0,
                'error'   => 'Unknown error'
            ])
        );
    }
}