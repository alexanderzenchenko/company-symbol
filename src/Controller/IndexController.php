<?php

namespace App\Controller;

use App\Form\Type\HistoricalQuotesSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('', 'homepage')]
    public function index(Request $request): Response
    {
        $searchForm = $this->createForm(HistoricalQuotesSearchType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            return $this->redirectToRoute('show_data');
        }

        return $this->render('index/index.html.twig', [
            'form' => $searchForm,
        ]);
    }

    #[Route('show', 'show_data')]
    public function show(): Response
    {
        return new Response('OK');
    }
}
