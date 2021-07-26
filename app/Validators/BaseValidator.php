<?php

namespace App\Validators;

interface BaseValidator
{
    public function handle($validValuesForOptions, $key, $answer, $question);
}
