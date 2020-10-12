<?php 

namespace App\Module\Statistics\Controller;

use DateTime;
use App\Common\Api\Json\Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\Statistics\Action\ReserveHistoryAction;

class ReserveHistoryController
{
    private Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @Route("/reserve-history/from/{dateFrom}/to/{dateTo}/page/{page}", name="statistics-reserve-history")
     */
    public function history(
        string               $dateFrom,
        string               $dateTo,
        int                  $page,
        ReserveHistoryAction $action
    ): Response
    {
        return $this->api
                    ->makeRequest(fn() => $action->handle(
                        new DateTime($dateFrom),
                        new DateTime($dateTo),
                        $page
                    ))
                    ->buildResponse();
    }
}