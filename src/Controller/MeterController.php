<?php

namespace App\Controller;

use App\Converter\ConverterService;
use App\Entity\Substance;
use App\Repository\SubstanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeterController extends AbstractController
{
    /** @var ConverterService */
    private $converterService;

    public function __construct(ConverterService $converterService)
    {
        $this->converterService = $converterService;
    }

    public function index()
    {
        return $this->render('meter/index.html.twig', [
            'controller_name' => 'MeterController',
        ]);
    }

    public function convert($substance, $amount, $from, $to)
    {
        var_dump($this->converterService->convert($substance, $amount, $from, $to));

        return new Response('ok');
    }
}
