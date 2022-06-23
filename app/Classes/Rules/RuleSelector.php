<?php


namespace App\Classes\Rules;


use App\Rules\NifRule;
use App\Rules\PostalCodeRule;

class RuleSelector
{
    /**
     * @param string $key
     * @return mixed
     */
    public function getRule(string $key)
    {
        $rules = [
            'required'=>'required',
            'date'=>'date',
            'email'=>'email',
            'unique:users'=>'unique:users',
            'confirmed'=>'confirmed',
            'nif_rule'=>new NifRule(),
            'postal_code_rule'=>new PostalCodeRule(),
        ];

        return $rules[$key];
    }

    /**
     * @param array $rules_array
     * @return array
     */
    public function getFromArray(array $rules_array): array
    {
        $array = array();

        foreach ($rules_array as $rule)
        {
            $array[] = $this->getRule($rule);
        }

        return $array;
    }
}
