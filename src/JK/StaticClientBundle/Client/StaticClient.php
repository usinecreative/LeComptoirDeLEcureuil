<?php

namespace JK\StaticClientBundle\Client;

use GuzzleHttp\Client;
use SplFileInfo;

class StaticClient
{
    /**
     * Guzzle client
     *
     * @var Client
     */
    protected $client;

    /**
     * Url of the static server
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
            'base_uri' => $staticServerUrl
        ]);
        $this->staticServerUrl = $staticServerUrl;
    }

    public function post(SplFileInfo $file)
    {
        $this
            ->client
            ->post('/post', [
                    'multipart' => [
                        'name' => 'file',
                        'filename' => $file->getFilename(),
                        'contents' => file_get_contents($file->getRealPath())

                    ]
                ]
            );
    }
}
