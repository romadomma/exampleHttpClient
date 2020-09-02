<?php

use ExampleHttpClient\ExampleException;
use PHPUnit\Framework\TestCase;
use ExampleHttpClient\ExampleComment;

class ExampleCommentTest extends TestCase
{

    private ExampleComment $comment;

    protected function setUp(): void
    {
        $this->comment = new ExampleComment(['name' => 'Roman', 'text' => 'First comment']);
    }

    public function testConstructor()
    {
        $this->assertEquals('Roman', $this->comment->name);
        $this->assertEquals('First comment', $this->comment->text);
    }

    public function testRequired()
    {
        $this->expectException(ExampleException::class);
        $this->expectExceptionMessage('The \'id\' field is required');
        $this->comment->required(['id']);
    }

}
