<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CompareDateRule implements Rule
{
    protected  $start_date;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start)
    {
        $this->start_date = $start;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value > $this->start_date;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Start date should be less than end date';
    }
}
