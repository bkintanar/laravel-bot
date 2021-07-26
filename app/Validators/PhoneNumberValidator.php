<?php

namespace App\Validators;

class PhoneNumberValidator extends Validator implements BaseValidator
{
    // validate for phone number field
    public function handle($validValuesForOptions, $key, $answer, $question)
    {
        if (! is_array($validValuesForOptions) && $validValuesForOptions === 'phone') {
            if (ctype_digit($answer) && strlen($answer) == 10) {
                return true;
            }

            $this->error = "Invalid answer detected: `{$answer}`. Please only enter a numbers in phone number without any spaces or special characters.";
        }

        return $this->error;
    }
}
