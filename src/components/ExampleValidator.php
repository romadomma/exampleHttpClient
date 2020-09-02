<?php

namespace ExampleHttpClient;

/**
 * Trait ExampleValidator
 * @package ExampleHttpClient
 */
trait ExampleValidator
{
    /**
     * @param array $required
     * @return bool
     * @throws ExampleException
     */
    public function required($required = []) : bool
    {
        foreach ($required as $field){
            if (empty($this->$field))
                throw new ExampleException("The '$field' field is required");
        }
        return true;
    }
}
