<?php

namespace ExampleHttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class ExampleClient
 * @package ExampleHttpClient
 */
class ExampleClient
{

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * ExampleClient constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->client = new Client(
            array_merge(
                $options,
                ['base_uri' => 'http://example.com']
            )
        );
    }

    /**
     * @param $method
     * @param $uri
     * @param $options
     * @return mixed
     * @throws ExampleException
     */
    protected function sendRequest($method, $uri, $options)
    {
        try {
            $response = $this->client->request($method, $uri, $options);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            throw new ExampleException('Problem with the http request, please try again later');
        }
    }

    /**
     * @param array $options
     * @return array
     * @throws ExampleException
     */
    public function getComments(array $options = []): array
    {
        $comments = $this->sendRequest('GET', '/comments', $options);
        if (!is_array($comments))
            throw new ExampleException('The service returned invalid data');
        return array_map(fn($comment) => new ExampleComment($comment), $comments);
    }

    /**
     * @param ExampleComment $comment
     * @param array $options
     * @return ExampleComment
     * @throws ExampleException
     */
    public function addComment(ExampleComment $comment, array $options = []): ExampleComment
    {
        $response = $this->sendRequest('POST', '/comment', array_merge(
            $options,
            ['json' => json_encode($comment)]
        ));
        return new ExampleComment($response);
    }

    /**
     * @param ExampleComment $comment
     * @param array $options
     * @return ExampleComment
     * @throws ExampleException
     */
    public function updateComment(ExampleComment $comment, array $options = []): ExampleComment
    {
        $comment->required(['id']);
        $response = $this->sendRequest('PUT', '/comment/' . $comment->id, array_merge(
            $options,
            ['json' => json_encode($comment)]
        ));
        return new ExampleComment($response);
    }

}
