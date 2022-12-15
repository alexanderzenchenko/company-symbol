<?php

namespace App\Controller;

use App\Form\Type\HistoricalQuotesSearchType;
use App\Service\HistoricalQuotesService\HistoricalQuotesServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('', 'homepage')]
    public function index(
        Request $request,
        HistoricalQuotesServiceInterface $historicalQuotesService
    ): Response
    {
        $prices = [];

        $searchForm = $this->createForm(HistoricalQuotesSearchType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $searchData = $searchForm->getData();

            $prices = $historicalQuotesService->getPricesBySearchConditions($searchData);
        }

        return $this->render('index/index.html.twig', [
            'form' => $searchForm,
            'prices' => $prices
        ]);
    }
}
