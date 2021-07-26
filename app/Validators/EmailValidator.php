<?php

namespace App\Validators;

class EmailValidator extends Validator implements BaseValidator
{
    // validate for email field
    public function handle($validValuesForOptions, $key, $answer, $question)
    {
        if (! is_array($validValuesForOptions) && $validValuesForOptions === 'email') {
            if (filter_var($answer, FILTER_VALIDATE_EMAIL)) {
                return true;
            }

            $this->error = "Invalid answer detected: `{$answer}`. Answer for the question `{$question}` must be a valid email.";
        }

        return $this->error;
    }
}
