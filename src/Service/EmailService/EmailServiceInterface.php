<?php

namespace App\Service\EmailService;

interface EmailServiceInterface
{
    /**
     * @param string $to
     * @param array $data
     * @return void
     */
    public function send(string $to, array $data): void;
}
