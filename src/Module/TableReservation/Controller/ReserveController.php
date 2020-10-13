<?php

namespace App\Module\TableReservation\Controller;

use DateTime;
use App\Common\Api\Json\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\TableReservation\Action\Reserve\CreateAction;
use App\Module\TableReservation\Action\Reserve\DeleteAction;
use App\Module\TableReservation\Action\Reserve\FindOneAction;
use App\Module\TableReservation\Action\Reserve\FindActualByTableAction;

class ReserveController
{
    private Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @Route("/reserve/{id<\d+>}", methods={"GET"}, name="reserve-single")
     */
    public function findOne(FindOneAction $action, int $id)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle($id))
                    ->buildResponse();
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
                        $request->get('client_name'),
                        new DateTime($request->get('time_from')),
                        new DateTime($request->get('time_to'))
                    ))
                    ->buildResponse();
    }

    /**
     * @Route("/reserve/{id<\d+>}", methods={"DELETE"}, name="reserve-delete")
     */    
    public function delete(DeleteAction $action, int $id)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle($id))
                    ->buildResponse();
    }
}