<?php

namespace App\Module\TableReservation\Controller;

use App\Common\Api\Json\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\TableReservation\Action\Table\CreateAction;
use App\Module\TableReservation\Action\Table\DeleteAction;
use App\Module\TableReservation\Action\Table\FindOneAction;
use App\Module\TableReservation\Action\Table\FindAllAction;

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
                        $request->get('number')
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