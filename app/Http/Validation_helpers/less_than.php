<?php

namespace App\Http\Validation_helpers;

use Illuminate\Support\Facades\Validator;

abstract class less_than
{
    public static function lessThan()
    {
        Validator::extend('less_than_field', function ($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$min_field];

            return $value < $min_value;
        });

        Validator::replacer('less_than_field', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });
    }
}
