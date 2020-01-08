<?php

namespace App\Controller\Api;

use App\Service\FundsTransferProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MoneyTransferController extends AbstractController
{
    /**
     * @Route("api/money-transfer", methods={"POST"})
     *
     * @param Request $request
     * @param FundsTransferProcessor $processor
     *
     * @return JsonResponse
     *
     * @throws \App\Exception\NotEnoughMoneyException
     */
    public function transfer(
        Request $request,
        FundsTransferProcessor $processor
    )
    {
        $content = $request->getContent();
        $data = \json_decode(
            $content,
            true
        );

        $processor->transfer(
            $data['sourceUserId'],
            $data['targetUserId'],
            $data['amount']
        );

        return $this->json('OK');
    }

}
