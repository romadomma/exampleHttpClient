<?php

use ExampleHttpClient\ExampleException;
use PHPUnit\Framework\TestCase;
use ExampleHttpClient\ExampleComment;

/**
 * Class ExampleCommentTest
 */
class ExampleCommentTest extends TestCase
{

    /**
     * @var ExampleComment
     */
    private ExampleComment $comment;

    /**
     * @throws ExampleException
     */
    protected function setUp(): void
    {
        $this->comment = new ExampleComment(['name' => 'Roman', 'text' => 'First comment']);
    }

    /**
     *
     */
    public function testConstructor()
    {
        $this->assertEquals('Roman', $this->comment->name);
        $this->assertEquals('First comment', $this->comment->text);
    }

    /**
     * @throws ExampleException
     */
    public function testRequired()
    {
        $this->expectException(ExampleException::class);
        $this->expectExceptionMessage('The \'id\' field is required');
        $this->comment->required(['id']);
    }

}
