<?php

namespace App\Module\Authentication\Controller;

use App\Common\Api\Json\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\Authentication\Action\LoginAction;
use App\Module\Authentication\Action\RegisterAction;
use App\Module\Authentication\Action\ChangePasswordAction;

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
                        $request->get('username'),
                        $request->get('password'),
                        $request->get('email')
                    ))
                    ->buildResponse();
    }

    /**
     * @Route("/login", name="user-login")
     */
    public function login(Request $request, LoginAction $action): Response
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle(
                        $request->get('username'),
                        $request->get('password')
                    ))
                    ->buildResponse();
    }

    /**
     * @Route("/user/password", methods={"PUT"}, name="user-change-password")
     */
    public function changePassword(Request $request, ChangePasswordAction $action): Response
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle(
                        $request->get('username'),
                        $request->get('current_password'),
                        $request->get('new_password')
                    ))
                    ->buildResponse();
    }
}