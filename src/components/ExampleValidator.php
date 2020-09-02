<?php

namespace ExampleHttpClient;

trait ExampleValidator
{
    public function required($required = []) : bool
    {
        foreach ($required as $field){
            if (empty($this->$field))
                throw new ExampleException("The '$field' field is required");
        }
        return true;
    }
}
