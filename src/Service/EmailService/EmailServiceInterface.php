<?php

namespace App\Service\EmailService;

interface EmailServiceInterface
{
    public function send(string $to, array $data): void;
}
