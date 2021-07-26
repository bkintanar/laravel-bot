<?php

namespace App\Validators;

use Exception;
use Illuminate\Support\Carbon;

class DateValidator extends Validator implements BaseValidator
{
    // validate for date field
    public function handle($validValuesForOptions, $key, $answer, $question)
    {
        if (! is_array($validValuesForOptions) && $validValuesForOptions === 'date') {
            try {
                Carbon::parse($answer);

                return true;
            } catch (Exception $e) {
                $this->error = "Invalid answer detected: `{$answer}`. Answer for the question `{$question}` must be a valid date with format mm/dd/yyyy.";
            }
        }

        return $this->error;
    }
}
