<?php

namespace App\Module\Authentication\Controller;

use App\Common\Api\Json\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\Authentication\Action\LoginAction;
use App\Module\Authentication\Action\RegisterAction;

class AuthController
{
    private Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @Route("/register", methods={"POST"}, name="user-register")
     */
    public function register(Request $request, RegisterAction $action): Response
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle(
                        json_decode($request->getContent())->username,
                        json_decode($request->getContent())->password,
                        json_decode($request->getContent())->email
                    ))
                    ->buildResponse();
    }

    /**
     * @Route("/login", name="user-login")
     */
    public function getTokenUser(Request $request, LoginAction $action): Response
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle(
                        json_decode($request->getContent())->username,
                        json_decode($request->getContent())->password
                    ))
                    ->buildResponse();
    }
}