<?php

namespace App\Controller;

use App\Service\CompanyService\Validator\CompanyValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ValidationController extends AbstractController
{
    #[Route('validation/validate/{symbol}', 'validation')]
    public function validate(CompanyValidatorInterface $service, string $symbol = '')
    {
        $isValidSymbol = $service->validate(trim($symbol));

        return $this->json(['isValid' => $isValidSymbol]);
    }
}
