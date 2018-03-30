<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $validation_rules = [];

    /**
     * Set the validation rules
     *
     * @param array $rules  The rules to validate the data passed from the client
     */
    public function setValidationRules(array $rules = [])
    {
        $this->validation_rules = $rules;
    }

    /**
     * Get the validation rules
     */
    public function getValidationRules()
    {
        return $this->validation_rules;
    }
}
