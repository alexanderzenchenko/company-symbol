<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class ConstrainsCompanySymbol extends Constraint
{
    public $message = '{{ string }} is not valid company symbol';
}
