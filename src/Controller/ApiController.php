<?php


namespace App\Controller;


use App\Converter\ConverterService;
use App\Repository\RepositoryLocatorTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiController extends AbstractController
{
    use RepositoryLocatorTrait;

    /** @var ConverterService */
    private $converterService;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(ConverterService $converterService, EntityManagerInterface  $em)
    {
        $this->converterService = $converterService;
        $this->em = $em;
    }

    public function convert(Request $request)
    {
        $substance = $request->query->get('substance');
        $from = $request->query->get('unit_from');
        $to = $request->query->get('unit_to');
        $amount = $request->query->get('amount');

        $key = $request->query->get('key', 'id');
        switch ($key) {
            case 'id':
                $substance = $this->getSubstanceRepository()->find($substance);
                $from = $this->getUnitRepository()->find($from);
                $to = $this->getUnitRepository()->find($to);
                break;
            case 'name':
            case 'search':
            default:
                return $this->errorResponse('Wrong key');
        }

        try {
            $result = $this->converterService->convert($substance, $amount, $from, $to);
        } catch (Throwable $t) {
            //todo log
            //todo, stub message for production
            return $this->errorResponse($t->getMessage());
        }
        $result = number_format($result, 2);
        return $this->successResponse($result);
    }

    private function successResponse(string $str): Response
    {
        $data = [
            'status' => 'ok',
            'message' => '',
            'body' => $str,
        ];

        return new Response(json_encode($data));
    }

    private function errorResponse(string $str): Response
    {
        $data = [
            'status' => 'error',
            'message' => 'Error',
            'body' => $str,
        ];

        return new Response(json_encode($data), 400);
    }
}
