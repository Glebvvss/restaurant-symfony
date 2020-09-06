<?php

namespace App\Controller;

use DateTime;
use App\Api\Json\Api;
use App\Action\Reserve\CreateAction;
use Symfony\Component\HttpFoundation\Request;
use App\Action\Reserve\FindActualByTableAction;
use Symfony\Component\Routing\Annotation\Route;

class ReserveController
{
    private Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @Route("/hall/{hallId<\d+>}/table/{tableNumber<\d+>}/reserve", methods={"GET"}, name="reserve-list-table-active")
     */
    public function findActualByTable(FindActualByTableAction $action, int $hallId, int $tableNumber)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle($hallId, $tableNumber))
                    ->buildResponse();
    }

    /**
     * @Route("/hall/{hallId<\d+>}/table/{tableNumber<\d+>}/reserve", methods={"POST"}, name="reserve-create")
     */
    public function create(
        CreateAction $action, 
        Request      $request,
        int          $hallId,
        int          $tableNumber
    )
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle(
                        $hallId,
                        $tableNumber,
                        json_decode($request->getContent())->client_name,
                        new DateTime(json_decode($request->getContent())->time_from),
                        new DateTime(json_decode($request->getContent())->time_to)
                    ))
                    ->buildResponse();
    }
}