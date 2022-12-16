<?php

namespace App\Controller;

use App\Entity\HistoricalQuoteSearchData;
use App\Form\Type\HistoricalQuotesSearchType;
use App\Service\CompanyService\Reader\CompanyReaderInterface;
use App\Service\EmailService\EmailService;
use App\Service\HistoricalQuotesService\HistoricalQuotesServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    protected const DATE_FORMAT = 'Y-m-d';

    #[Route('', 'homepage')]
    public function index(
        Request                          $request,
        HistoricalQuotesServiceInterface $historicalQuotesService,
        CompanyReaderInterface           $reader,
        EmailService                     $emailService
    ): Response
    {
        $prices = [];

        $searchForm = $this->createForm(HistoricalQuotesSearchType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            /** @var HistoricalQuoteSearchData $searchData */
            $searchData = $searchForm->getData();

            $prices = $historicalQuotesService->getPricesBySearchConditions($searchData);

            $company = $reader->getCompany($searchData->getCompanySymbol());

            $emailService->send($searchData->getEmail(), [
                'subject' => $company->getCompanyName(),
                'text' => sprintf(
                    'From %s to %s',
                    $searchData->getStartDate()->format(static::DATE_FORMAT),
                    $searchData->getEndDate()->format(static::DATE_FORMAT)
                ),
            ]);
        }

        return $this->render('index/index.html.twig', [
            'form' => $searchForm,
            'prices' => $prices
        ]);
    }
}
