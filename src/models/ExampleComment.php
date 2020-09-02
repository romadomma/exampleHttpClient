<?php

namespace ExampleHttpClient;

/**
 * Class ExampleComment
 * @package ExampleHttpClient
 */
class ExampleComment
{

    use ExampleValidator;

    /**
     * @var int
     */
    public int $id;
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public string $text;

    /**
     * ExampleComment constructor.
     * @param array $param
     * @throws ExampleException
     */
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
