<?php

namespace JK\StaticClientBundle\Client;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use SplFileInfo;

class StaticClient
{
    /**
     * Guzzle client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Url of the static server.
     *
     * @var
     */
    protected $staticServerUrl;

    /**
     * StaticClient constructor.
     *
     * @param $staticServerUrl
     */
    public function __construct($staticServerUrl)
    {
        // guzzle client creation
        $this->client = new Client([
            'base_uri' => 'http://127.0.0.1:8000',
        ]);
        $this->staticServerUrl = $staticServerUrl;
    }

    public function post(SplFileInfo $file)
    {
        if (!$file->isReadable()) {
            throw new Exception('File '.$file->getRealPath().' is not readable');
        }

        try {
            $response = $this
                ->client
                ->post('/post', [
                        'multipart' => [
                            [
                                'name' => 'file_post[file]',
                                'filename' => $file->getFilename().'.'.$file->getExtension(),
                                'contents' => file_get_contents($file->getRealPath()),
                            ],
                            [
                                'name' => 'file_post[application]',
                                'contents' => 'le_comptoir',
                            ],
                            [
                                'name' => 'file_post[password]',
                                'contents' => 'test',
                            ],
                        ],
                    ]
                );

            // get new url from server response
            $url = $response->getBody();
        } catch (RequestException $e) {
            $url = false;
        }

        return $url;
    }
}
