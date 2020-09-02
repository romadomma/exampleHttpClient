<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ExampleHttpClient\ExampleClient;
use ExampleHttpClient\ExampleException;
use ExampleHttpClient\ExampleComment;

/**
 * Class ExampleClientTest
 */
class ExampleClientTest extends TestCase
{

    /**
     * @var ExampleClient
     */
    private ExampleClient $client;
    /**
     * @var MockHandler
     */
    private MockHandler $mock;
    /**
     * @var ExampleComment
     */
    private ExampleComment $comment;
    /**
     * @var ExampleComment
     */
    private ExampleComment $commentWithoutId;

    /**
     * @throws ExampleException
     */
    protected function setUp(): void
    {
        $this->mock = new MockHandler();
        $handlerStack = HandlerStack::create($this->mock);
        $this->client = new ExampleClient(['handler' => $handlerStack]);
        $this->comment = new ExampleComment(['id' => 1, 'name' => 'Roman', 'text' => 'First comment']);
        $this->commentWithoutId = new ExampleComment(['name' => 'Roman', 'text' => 'Second comment']);
    }

    /**
     * @throws ExampleException
     */
    public function testGetComments() {
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/json; charset=utf-8'],
            json_encode([['id' => 1, 'name' => 'Roman', 'text' => 'First comment']])
        ));
        $comments = $this->client->getComments();
        $this->assertEquals(1, $comments[0]->id);
        $this->assertEquals('Roman', $comments[0]->name);
        $this->assertEquals('First comment', $comments[0]->text);
    }

    /**
     * @throws ExampleException
     */
    public function testGetCommentsFail() {
        $this->expectException(ExampleException::class);
        $this->expectExceptionMessage('Problem with the http request, please try again later');
        $this->mock->append(new Response(500));
        $this->client->getComments();
    }

    /**
     * @throws ExampleException
     */
    public function testGetCommentsInvalidData() {
        $this->expectException(ExampleException::class);
        $this->expectExceptionMessage('The service returned invalid data');
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/text; charset=utf-8'],
            'data'
        ));
        $this->client->getComments();
    }

    /**
     * @throws ExampleException
     */
    public function testGetCommentsInvalidJsonData() {
        $this->expectException(ExampleException::class);
        $this->expectExceptionMessage('Class \'ExampleHttpClient\ExampleComment\' does not contain the \'uid\' attribute');
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/json; charset=utf-8'],
            json_encode([['uid' => 1, 'surname' => 'Kadykov', 'car' => 'Toyota']])
        ));
        $this->client->getComments();
    }

    /**
     * @throws ExampleException
     */
    public function testAddComment() {
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/json; charset=utf-8'],
            json_encode(['id' => 1, 'name' => 'Roman', 'text' => 'First comment'])
        ));
        $comments = $this->client->addComment($this->commentWithoutId);
        $this->assertEquals(1, $comments->id);
        $this->assertEquals('Roman', $comments->name);
        $this->assertEquals('First comment', $comments->text);
    }

    /**
     * @throws ExampleException
     */
    public function testAddCommentFail() {
        $this->expectException(ExampleException::class);
        $this->expectExceptionMessage('Problem with the http request, please try again later');
        $this->mock->append(new Response(500));
        $this->client->addComment($this->commentWithoutId);
    }

    /**
     * @throws ExampleException
     */
    public function testAddCommentInvalidData() {
        $this->expectException(TypeError::class);
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/text; charset=utf-8'],
            'data'
        ));
        $this->client->addComment($this->commentWithoutId);
    }

    /**
     * @throws ExampleException
     */
    public function testAddCommentInvalidJsonData() {
        $this->expectException(ExampleException::class);
        $this->expectExceptionMessage('Class \'ExampleHttpClient\ExampleComment\' does not contain the \'uid\' attribute');
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/json; charset=utf-8'],
            json_encode(['uid' => 1, 'surname' => 'Kadykov', 'car' => 'Toyota'])
        ));
        $this->client->addComment($this->commentWithoutId);
    }

    /**
     * @throws ExampleException
     */
    public function testAddCommentInvalidArg() {
        $this->expectException(TypeError::class);
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/json; charset=utf-8'],
            json_encode(['id' => 1, 'name' => 'Roman', 'text' => 'First comment'])
        ));
        $this->client->addComment(['someKey' => 'someData']);
    }

    /**
     * @throws ExampleException
     */
    public function testUpdateComment() {
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/json; charset=utf-8'],
            json_encode(['id' => 1, 'name' => 'Roman', 'text' => 'First comment'])
        ));
        $comments = $this->client->updateComment($this->comment);
        $this->assertEquals(1, $comments->id);
        $this->assertEquals('Roman', $comments->name);
        $this->assertEquals('First comment', $comments->text);
    }

    /**
     * @throws ExampleException
     */
    public function testUpdateCommentWithoutId() {
        $this->expectException(ExampleException::class);
        $this->expectExceptionMessage('The \'id\' field is required');
        $this->mock->append(new Response(400));
        $this->client->updateComment($this->commentWithoutId);
    }

    /**
     * @throws ExampleException
     */
    public function testUpdateCommentFail() {
        $this->expectException(ExampleException::class);
        $this->expectExceptionMessage('Problem with the http request, please try again later');
        $this->mock->append(new Response(500));
        $this->client->updateComment($this->comment);
    }

    /**
     * @throws ExampleException
     */
    public function testUpdateCommentInvalidData() {
        $this->expectException(TypeError::class);
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/text; charset=utf-8'],
            'data'
        ));
        $this->client->updateComment($this->comment);
    }

    /**
     * @throws ExampleException
     */
    public function testUpdateCommentInvalidJsonData() {
        $this->expectException(ExampleException::class);
        $this->expectExceptionMessage('Class \'ExampleHttpClient\ExampleComment\' does not contain the \'uid\' attribute');
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/json; charset=utf-8'],
            json_encode(['uid' => 1, 'surname' => 'Kadykov', 'car' => 'Toyota'])
        ));
        $this->client->updateComment($this->comment);
    }

    /**
     * @throws ExampleException
     */
    public function testUpdateCommentInvalidArg() {
        $this->expectException(TypeError::class);
        $this->mock->append(new Response(200,
            ['Content-Type' => 'application/json; charset=utf-8'],
            json_encode(['id' => 1, 'name' => 'Roman', 'text' => 'First comment'])
        ));
        $this->client->updateComment(['someKey' => 'someData']);
    }

}
