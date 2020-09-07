<?php

namespace App\Controller;

use App\Api\Json\Api;
use App\Action\Hall\CreateAction;
use App\Action\Hall\UpdateAction;
use App\Action\Hall\DeleteAction;
use App\Action\Hall\FindOneAction;
use App\Action\Hall\FindAllAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HallController
{
    private Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @Route("/hall", methods={"GET"}, name="hall-list")
     */
    public function findAll(FindAllAction $action)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle())
                    ->buildResponse();
    }

    /**
     * @Route("/hall/{id<\d+>}", methods={"GET"}, name="hall-single")
     */
    public function findOne(FindOneAction $action, int $id)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle($id))
                    ->buildResponse();
    }

    /**
     * @Route("/hall", methods={"POST"}, name="hall-create")
     */
    public function create(CreateAction $action, Request $request)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle(
                        json_decode($request->getContent())->name
                    ))
                    ->buildResponse();
    }

    /**
     * @Route("/hall/{id<\d+>}", methods={"PUT"}, name="hall-update")
     */
    public function update(
        UpdateAction $action, 
        Request      $request,
        int          $id
    )
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle(
                        $id,
                        json_decode($request->getContent())->name
                    ))
                    ->buildResponse();
    }

    /**
     * @Route("/hall/{id<\d+>}", methods={"DELETE"}, name="hall-delete")
     */
    public function delete(DeleteAction $action, int $id)
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle($id))
                    ->buildResponse();
    }
}