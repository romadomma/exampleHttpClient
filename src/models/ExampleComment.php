<?php

namespace ExampleHttpClient;

class ExampleComment
{

    use ExampleValidator;

    public int $id;
    public string $name;
    public string $text;

    function __construct(array $param = [])
    {
        foreach ($param as $key => $value) {
            if (property_exists(self::class ,$key))
                $this->$key = $value;
            else
                throw new ExampleException("Class '".self::class."' does not contain the '$key' attribute");
        }
    }
}
