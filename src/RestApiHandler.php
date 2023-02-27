<?php

// Declare strict typing to enforce data types in the code
declare(strict_types=1);

// Define a namespace for the class

namespace ccl\countrycryptolaws;

// Define a class called RestApiHandler
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RestApiHandler
{
    // Define private class properties for the REST API URL and HTTP client
    private $apiUrl;
    private $client;

    /**
     * Define a constructor for the class that takes a REST API URL and HTTP client as parameters
     *
     * RestApiHandler constructor.
     * @param string $restApiUrl
     * @param Client $client
     */
    public function __construct(string $restApiUrl, Client $client)
    {
        // Assign the REST API URL and HTTP client to the corresponding class properties
        $this->apiUrl = $restApiUrl;
        $this->client = $client;
    }

    /**
     * Define a public method called "getList" that returns an array of List of countries
     *
     * @return array
     * @throws GuzzleException
     */
    public function getList(): array
    {
        try {
            // Send a HTTP GET request to the REST API URL using the HTTP client object
            $res = $this->client->request('GET', $this->apiUrl);

            // If the response status code is 200, return an array with the "result" key set to true and the "body" key set to the JSON-decoded contents of the response body
            if ($res->getStatusCode() === 200) {
                return [
                    'result' => true,
                    'body' => json_decode(($res->getBody()->getContents()), true)
                ];
            }
        } catch (\Exception $e) {
            // If an exception is thrown, return an array with the "result" key set to false and the "body" key set to an error message
            return [
                'result' => false,
                'body' => _e('We have encountered an issue with the source of the List of Countries.', 'ccl')
            ];
        }
    }
}
