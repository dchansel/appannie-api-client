<?php

namespace dchansel\AppAnnieApiClient\Client;

use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Client;

class AppAnnieClient extends GuzzleClient
{
    /**
     * {@inheritdoc}
     */
    public static function factory($config = [])
    {
        $required = ['api_key'];

        foreach ($required as $value) {
            if (!isset($config[$value]) || !$config[$value]) {
                throw new \InvalidArgumentException(sprintf('Argument "%s" is required.', $value));
            }
        }

        //$version = isset($config['version']) ? (int) $config['version'] : 20160901;
        //$mode    = isset($config['mode']) ? $config['mode'] : 'foursquare';

        //static::validateVersion($version);
        //static::validateMode($mode);

        $client = new Client([
            'base_url' => 'https://api.appannie.com/v1.2/',
            'defaults' => [
                'headers' => ['Authorization' => 'bearer ' . $config['api_key']]
                ],
            ]
        ]);

        //$directory   = $version >= 20160901 ? 20160901 : 20130707;
        $contents    = file_get_contents(sprintf('%s/../Resources/config/client.json', __DIR__));
        $description = new Description(json_decode($contents, true));

        return new static($client, $description);
    }
}