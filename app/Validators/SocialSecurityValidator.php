<?php

namespace App\Validators;

class SocialSecurityValidator extends Validator implements BaseValidator
{
    // validate for social security field
    public function handle($validValuesForOptions, $key, $answer, $question)
    {
        if (! is_array($validValuesForOptions) && $validValuesForOptions === 'ssn') {
            if (ctype_digit($answer) && strlen($answer) == 9) {
                return true;
            }

            $this->error = "Invalid answer detected: `{$answer}`. Please only enter a numbers in social security no. without any spaces or special characters.";
        }

        return $this->error;
    }
}
