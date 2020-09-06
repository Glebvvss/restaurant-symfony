<?php

namespace App\Controller;

use App\Api\Json\Api;
use App\Action\Table\CreateAction;
use App\Action\Table\DeleteAction;
use App\Action\Table\FindOneAction;
use App\Action\Table\FindAllAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TableController
{
    private Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @Route("/hall/{hallId<\d+>}/table", methods={"GET"}, name="table-list")
     */
    public function findAll(FindAllAction $action, int $hallId)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle($hallId))
                    ->buildResponse();
    }

    /**
     * @Route("/hall/{hallId<\d+>}/table/{number<\d+>}", methods={"GET"}, name="table-single")
     */
    public function findOne(FindOneAction $action, int $hallId, int $number)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle($hallId, $number))
                    ->buildResponse();
    }

    /**
     * @Route("/hall/{hallId<\d+>}/table", methods={"POST"}, name="table-create")
     */
    public function create(CreateAction $action, Request $request, int $hallId)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle(
                        $hallId,
                        json_decode($request->getContent())->number
                    ))
                    ->buildResponse();
    }

    /**
     * @Route("/hall/{hallId<\d+>}/table/{number<\d+>}", methods={"DELETE"}, name="table-delete")
     */
    public function delete(DeleteAction $action, int $hallId, int $number)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle($hallId, $number))
                    ->buildResponse();
    }
}