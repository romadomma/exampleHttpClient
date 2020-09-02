<?php

namespace ExampleHttpClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ExampleClient
{

    protected Client $client;

    public function __construct(array $options = [])
    {
        $this->client = new Client(
            array_merge(
                $options,
                ['base_uri' => 'http://example.com']
            )
        );
    }

    protected function sendRequest($method, $uri, $options)
    {
        try {
            $response = $this->client->request($method, $uri, $options);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            throw new ExampleException('Problem with the http request, please try again later');
        }
    }

    public function getComments(array $options = []): array
    {
        $comments = $this->sendRequest('GET', '/comments', $options);
        if (!is_array($comments))
            throw new ExampleException('The service returned invalid data');
        return array_map(fn($comment) => new ExampleComment($comment), $comments);
    }

    public function addComment(ExampleComment $comment, array $options = []): ExampleComment
    {
        if (!($comment instanceof ExampleComment))
            throw new ExampleException('Comment object must be an instance of the class ExampleComment');
        $response = $this->sendRequest('POST', '/comment', array_merge(
            $options,
            ['json' => json_encode($comment)]
        ));
        return new ExampleComment($response);
    }

    public function updateComment(ExampleComment $comment, array $options = []): ExampleComment
    {
        if (!($comment instanceof ExampleComment))
            throw new ExampleException('Comment object must be an instance of the class ExampleComment');
        $comment->required(['id']);
        $response = $this->sendRequest('PUT', '/comment/' . $comment->id, array_merge(
            $options,
            ['json' => json_decode($comment)]
        ));
        return new ExampleComment($response);
    }

}
