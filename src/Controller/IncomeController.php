<?php

namespace App\Controller;

use App\Service\IncomeProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncomeController extends AbstractController
{
    /**
     * @Route("/income/add", methods={"POST", "PATCH"})
     */
    public function add(
        Request $request,
        IncomeProcessor $incomeProcessor
    )
    {

    }

}
