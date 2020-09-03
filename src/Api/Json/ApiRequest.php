<?php

namespace App\Api\Json;

use Throwable;
use App\Exception\ErrorReporting;
use App\Api\Contract\ApiRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiRequest implements ApiRequestInterface
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function buildResponse(): JsonResponse
    {
        try {
            return new JsonResponse(
                $this->makeOkContent(
                    (array) call_user_func($this->callback)
                ) 
            );
        }
        catch (ErrorReporting $ex) {
            return new JsonResponse(
                $this->makeFailContent($ex->getMessage())
            );
        }
        catch (Throwable $ex) {
            return new JsonResponse(
                $this->makeFailContent('Unknown error')
            );
        }
    }

    private function makeOkContent(array $data)
    {
        if (empty($data)) {
            return ['success' => 1];
        }

        return [
            'success' => 1,
            'data'    => $data
        ];
    }

    private function makeFailContent(string $message)
    {
        return [
            'success' => 0,
            'error'   => $message
        ];
    }
}